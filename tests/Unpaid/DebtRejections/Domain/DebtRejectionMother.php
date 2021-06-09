<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\Uuid;
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
            ->setId(new Uuid('519ec3f0-589d-4fa7-9595-52e6249e2957'))
            ->setBankFileName(new BankFileName(self::TEST_FILE_NAME))
            ->setCreationDateTime(new CreationDateTime('2021-05-21T06:00:01'))
            ->setRefundId(new RefundId('4806B60007270401'))
            ->setInternalId(new Rdsdb5ClientId('4806B60007270401'))
            ->setTransactionStatus(new TransactionStatus('RJCT'))
            ->setStatusReasonCode(new StatusReasonCode('AG01'))
            ->setDebtAmount(new DebtAmount('29.96'))
            ->setPaymentDate(new PaymentDate('2021-05-17'))
            ->setDebtorAccount(new DebtorAccount('ESXXXXXXXXXXXXXXXXXXXXXX'))
            ->setCreditorAccount(new DigiAccount('ESYYYYYYYYYYYYYYYYYYYYYY'))
            ->setDebtorName(new DebtorName('Dolores Fuertes de Barriga'))
            ->setProcessStatus(new ProcessStatus(0))
            ->build();
    }

    public static function getRowDataForCreation(): array{
        return [
            'id' => new Uuid('519ec3f0-589d-4fa7-9595-52e6249e2957'),
            'bankFileName' => self::TEST_FILE_NAME,
            'creationDateTime' => '2021-05-21T06:00:01',
            'refundId' => '4806B60007270401',
            'internalId' => '4806B60007270401',
            'transactionStatus' => 'RJCT',
            'statusReasonCode' => 'AG01',
            'debtAmount' => '29.96',
            'paymentDate' => '2021-05-17',
            'debtorAccount' => 'ESXXXXXXXXXXXXXXXXXXXXXX',
            'creditorAccount' => 'ESYYYYYYYYYYYYYYYYYYYYYY',
            'debtorName' => 'Dolores Fuertes de Barriga',
            'processStatus' => 0
        ];
    }
}
