<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Tests\Shared\Domain\DateMother;
use Financial\Tests\Shared\Domain\DateTimeMother;
use Financial\Tests\Shared\Domain\IbanMother;
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
    public static function create(): DebtRejection
    {
        $debtRejectionData = DebtRejectionMother::getRowDataForCreation();
        return self::fromRawData($debtRejectionData);
    }

    public static function fromRawData($debtRejectionData): DebtRejection
    {
        return (new DebtRejectionBuilder())
            ->setId($debtRejectionData['id'])
            ->setBankFileName(new BankFileName($debtRejectionData['bankFileName']))
            ->setCreationDateTime(new CreationDateTime($debtRejectionData['creationDateTime']))
            ->setRefundId(new RefundId($debtRejectionData['refundId']))
            ->setInternalId(new Rdsdb5ClientId($debtRejectionData['internalId']))
            ->setTransactionStatus(new TransactionStatus($debtRejectionData['transactionStatus']))
            ->setStatusReasonCode(new StatusReasonCode($debtRejectionData['statusReasonCode']))
            ->setDebtAmount(new DebtAmount($debtRejectionData['debtAmount']))
            ->setPaymentDate(new PaymentDate($debtRejectionData['paymentDate']))
            ->setDebtorAccount(new DebtorAccount($debtRejectionData['debtorAccount']))
            ->setCreditorAccount(new DigiAccount($debtRejectionData['creditorAccount']))
            ->setDebtorName(new DebtorName($debtRejectionData['debtorName']))
            ->setProcessStatus(new ProcessStatus($debtRejectionData['processStatus']))
            ->build();
    }

    public static function getRowDataForCreation(): array
    {
        return [
            'id' => DebtRejectionIdMother::random(),
            'bankFileName' => BankFileNameMother::fileNameForTest(),
            'creationDateTime' => DateTimeMother::randomWithT(),
            'refundId' => '4806B60007270401',
            'internalId' => '4806B60007270401',
            'transactionStatus' => 'RJCT',
            'statusReasonCode' => 'AG01',
            'debtAmount' => '29.96',
            'paymentDate' => DateMother::random(),
            'debtorAccount' => IbanMother::random(),
            'creditorAccount' => IbanMother::random(),
            'debtorName' => DebtorNameMother::random(),
            'processStatus' => 0
        ];
    }
}
