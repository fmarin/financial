<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Unpaid\DebtRejections\Domain\BankFileName;
use Financial\Unpaid\DebtRejections\Domain\CreationDateTime;
use Financial\Unpaid\DebtRejections\Domain\DebtAmount;
use Financial\Unpaid\DebtRejections\Domain\DebtorAccount;
use Financial\Unpaid\DebtRejections\Domain\DebtorName;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionBuilder;
use Financial\Unpaid\DebtRejections\Domain\DigiAccount;
use Financial\Unpaid\DebtRejections\Domain\PaymentDate;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\DebtRejections\Domain\Rdsdb5ClientId;
use Financial\Unpaid\DebtRejections\Domain\RefundId;
use Financial\Unpaid\DebtRejections\Domain\StatusReasonCode;
use Financial\Unpaid\DebtRejections\Domain\TransactionStatus;

final class DebtRejectionMother
{
    const TEST_FILE_NAME = 'DDddmmyy.000.xml';

    public static function create(): DebtRejection
    {
        return (new DebtRejectionBuilder())
            ->setBankFileName(new BankFileName(self::TEST_FILE_NAME))
            ->setCreationDateTime(new CreationDateTime('2021-05-21T06:00:01'))
            ->setRefundId(new RefundId('4806B6'))
            ->setInternalId(new Rdsdb5ClientId('0007270401'))
            ->setTransactionStatus(new TransactionStatus('RJCT'))
            ->setStatusReasonCode(new StatusReasonCode('AG01'))
            ->setDebtAmount(new DebtAmount('29.96'))
            ->setPaymentDate(new PaymentDate('2021-05-17'))
            ->setDebtorAccount(new DebtorAccount('ES2930580990242753231782'))
            ->setCreditorAccount(new DigiAccount('ES9521008674140200010616'))
            ->setDebtorName(new DebtorName('Lidia Marta Vascan'))
            ->setProcessStatus(new ProcessStatus(0))
            ->build();
    }

    public static function random(): DebtRejection
    {
        return self::create();
    }
}
