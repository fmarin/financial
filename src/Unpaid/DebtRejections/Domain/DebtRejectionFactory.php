<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

class DebtRejectionFactory
{
    public static function create(array $data): DebtRejection
    {
        return (new DebtRejectionBuilder())
            ->setId($data['id'])
            ->setBankFileName(new BankFileName($data['bankFileName']))
            ->setCreationDateTime(new CreationDateTime($data['creationDateTime']))
            ->setRefundId(new RefundId($data['refundId']))
            ->setInternalId(new Rdsdb5ClientId($data['internalId']))
            ->setTransactionStatus(new TransactionStatus($data['transactionStatus']))
            ->setStatusReasonCode(new StatusReasonCode($data['statusReasonCode']))
            ->setDebtAmount(new DebtAmount($data['debtAmount']))
            ->setPaymentDate(new PaymentDate($data['paymentDate']))
            ->setDebtorAccount(new DebtorAccount($data['debtorAccount']))
            ->setCreditorAccount(new DigiAccount($data['creditorAccount']))
            ->setDebtorName(new DebtorName($data['debtorName']))
            ->setProcessStatus(new ProcessStatus($data['processStatus']))
            ->build();
    }
}