<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DevolutionValidatedDomainEventFactory
{
    const DEVOLUTION_INITIAL_STATUS = 0;

    public static function create(
        DebtRejection $debtRejection,
        Bancara $domiciliation,
        int $insertType
    ): DevolutionValidatedDomainEvent
    {
        $devolutionData = [
            'id' => $debtRejection->id(),
            'internalId' => $debtRejection->InternalId()->value(),
            'type' => $domiciliation->type()->value(),
            'creationDateTime' => $debtRejection->CreationDateTime()->value(),
            'bankId' => $domiciliation->bankId()->value(),
            'debtAmount' => $debtRejection->DebtAmount()->value(),
            'paymentDate' => $debtRejection->PaymentDate()->value(),
            'statusReasonCode' => $debtRejection->StatusReasonCode()->value(),
            'status' => self::DEVOLUTION_INITIAL_STATUS,
            'bankFileName' => $debtRejection->BankFileName()->value(),
            'localUserId' => 123456,
            'fileSource' => '/PATH/',
            'uniqueKey' => $debtRejection->refundId()->value() . $debtRejection->internalId()->value(),
            'debtorAccount' => $debtRejection->DebtorAccount()->value(),
            'creditorAccount' => $debtRejection->CreditorAccount()->value(),
            'suffix' => '',
            'rezInsert' => $insertType
        ];
        
        return new DevolutionValidatedDomainEvent($debtRejection->id()->value(), $devolutionData);
    }
}
