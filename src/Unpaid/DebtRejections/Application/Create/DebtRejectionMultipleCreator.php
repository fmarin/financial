<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Create;

use Financial\Unpaid\DebtRejections\Domain\BankFileName;
use Financial\Unpaid\DebtRejections\Domain\CreationDateTime;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionBuilder;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;
use Financial\Unpaid\DebtRejections\Domain\DigiAccount;
use Financial\Unpaid\DebtRejections\Domain\DebtAmount;
use Financial\Unpaid\DebtRejections\Domain\DebtorAccount;
use Financial\Unpaid\DebtRejections\Domain\DebtorName;
use Financial\Unpaid\DebtRejections\Domain\PaymentDate;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\DebtRejections\Domain\Rdsdb5ClientId;
use Financial\Unpaid\DebtRejections\Domain\RefundId;
use Financial\Unpaid\DebtRejections\Domain\StatusReasonCode;
use Financial\Unpaid\DebtRejections\Domain\TransactionStatus;

class DebtRejectionMultipleCreator
{
    const TRANSACTION_STATUS_REJECTED = 'RJCT';
    const INITIAL_PROCESS_STATUS = 0;

    private DebtRejectionRepository $repository;

    public function __construct(DebtRejectionRepository $repository)
    {
        $this->repository = $repository;
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
                    $orgnlEndToEndId = $informationAndStatus->OrgnlEndToEndId->__toString();
                    $stsRsnInfRsnCd = $informationAndStatus->StsRsnInf->Rsn->Cd->__toString();
                    $instdAmt = $informationAndStatus->OrgnlTxRef->Amt->InstdAmt->__toString();
                    $reqdColltnDt = $informationAndStatus->OrgnlTxRef->ReqdColltnDt->__toString();
                    $dbtrAcctIdIBAN = $informationAndStatus->OrgnlTxRef->DbtrAcct->Id->IBAN->__toString();
                    $cdtrAcctIdIBAN = $informationAndStatus->OrgnlTxRef->CdtrAcct->Id->IBAN->__toString();
                    $dbtrNm = $informationAndStatus->OrgnlTxRef->Dbtr->Nm->__toString();

                    $debtRejection = (new DebtRejectionBuilder())
                        ->setBankFileName(new BankFileName($fileName))
                        ->setCreationDateTime(new CreationDateTime($creDtTm))
                        ->setRefundId(new RefundId($orgnlEndToEndId))
                        ->setInternalId(new Rdsdb5ClientId($orgnlEndToEndId))
                        ->setTransactionStatus(new TransactionStatus($txSts))
                        ->setStatusReasonCode(new StatusReasonCode($stsRsnInfRsnCd))
                        ->setDebtAmount(new DebtAmount($instdAmt))
                        ->setPaymentDate(new PaymentDate($reqdColltnDt))
                        ->setDebtorAccount(new DebtorAccount($dbtrAcctIdIBAN))
                        ->setCreditorAccount(new DigiAccount($cdtrAcctIdIBAN))
                        ->setDebtorName(new DebtorName($dbtrNm))
                        ->setProcessStatus(new ProcessStatus(self::INITIAL_PROCESS_STATUS))
                        ->build();

                    $this->repository->save($debtRejection);

                }
            }
        }
    }
}