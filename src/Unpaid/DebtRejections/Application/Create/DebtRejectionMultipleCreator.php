<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Create;

use Financial\Shared\Domain\ValueObject\Uuid;

final class DebtRejectionMultipleCreator
{
    const TRANSACTION_STATUS_REJECTED = 'RJCT';
    const INITIAL_PROCESS_STATUS = 0;

    private DebtRejectionCreator $creator;

    public function __construct(DebtRejectionCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke($debtsRejectedFile, string $fileName)
    {
        $drGroupHeader = $debtsRejectedFile->CstmrPmtStsRpt->GrpHdr;
        $creDtTm = $drGroupHeader->CreDtTm->__toString();

        $drOriginalPaymentInformationAndStatus = $debtsRejectedFile->CstmrPmtStsRpt->OrgnlPmtInfAndSts;

        foreach($drOriginalPaymentInformationAndStatus as $originalPayment) {
            foreach($originalPayment->TxInfAndSts as $informationAndStatus) {
                $txSts = $informationAndStatus->TxSts->__toString();

                if($txSts == self::TRANSACTION_STATUS_REJECTED) {
                    $debtRejectionData = [
                        'id' => Uuid::random(),
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
                    ];

                    $this->creator->__invoke($debtRejectionData);
                }
            }
        }
    }
}