<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Create;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionFactory;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;

class DebtRejectionMultipleCreator
{
    const TRANSACTION_STATUS_REJECTED = 'RJCT';
    const INITIAL_PROCESS_STATUS = 0;

    private DebtRejectionRepository $repository;
    private EventBus $bus;

    public function __construct(DebtRejectionRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke(string $filePath, string $fileName)
    {
        $debtsRejected = simplexml_load_file($filePath);

        $drGroupHeader = $debtsRejected->CstmrPmtStsRpt->GrpHdr;
        $creDtTm = $drGroupHeader->CreDtTm->__toString();

        $drOriginalPaymentInformationAndStatus = $debtsRejected->CstmrPmtStsRpt->OrgnlPmtInfAndSts;

        foreach($drOriginalPaymentInformationAndStatus as $originalPayment) {
            foreach($originalPayment->TxInfAndSts as $informationAndStatus) {
                $txSts = $informationAndStatus->TxSts->__toString();

                if($txSts == self::TRANSACTION_STATUS_REJECTED) {
                    $debtRejection = DebtRejectionFactory::create([
                        'bankFileName' => $fileName,
                        'creationDateTime' => $creDtTm,
                        'refundId' => $informationAndStatus->OrgnlEndToEndId->__toString(),
                        'internalId' => $informationAndStatus->OrgnlEndToEndId->__toString(),
                        'transactionStatus' => $txSts,
                        'statusReasonCode' => $informationAndStatus->StsRsnInf->Rsn->Cd->__toString(),
                        'debtAmount' => $informationAndStatus->OrgnlTxRef->Amt->InstdAmt->__toString(),
                        'paymentDate' => $informationAndStatus->OrgnlTxRef->ReqdColltnDt->__toString(),
                        'debtorAccount' => $informationAndStatus->OrgnlTxRef->DbtrAcct->Id->IBAN->__toString(),
                        'creditorAccount' => $informationAndStatus->OrgnlTxRef->CdtrAcct->Id->IBAN->__toString(),
                        'debtorName' => $informationAndStatus->OrgnlTxRef->Dbtr->Nm->__toString(),
                        'processStatus' => self::INITIAL_PROCESS_STATUS
                    ]);

                    $this->repository->save($debtRejection);
                    $this->bus->publish(...$debtRejection->pullDomainEvents());
                }
            }
        }
    }
}