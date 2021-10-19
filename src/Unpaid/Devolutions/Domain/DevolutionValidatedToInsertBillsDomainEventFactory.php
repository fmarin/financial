<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Domiciliations\Domain\BankId;

final class DevolutionValidatedToInsertBillsDomainEventFactory
{
    public static function create(
        DebtRejection $debtRejection,
        BankId $bankId
    ): DevolutionValidatedToInsertBillsDomainEvent
    {
        $billData = [
            'id' => $debtRejection->id(),
            'clientId' => $debtRejection->InternalId()->valueAsNumeric(),
            'bankId' => $bankId->value(),
            'number' => $debtRejection->CreationDateTime()->generateNumberToBill(),
            'value' => $debtRejection->DebtAmount()->getValueInNegative(),
            'localUser' => 123456, // TODO: SET THE USER THAT EXECUTE THE PROCESS
            'date' => $debtRejection->CreationDateTime()->getDateToBill(),
            'statusReasonCode' => $debtRejection->statusReasonCode()->value()
        ];
        
        return new DevolutionValidatedToInsertBillsDomainEvent($debtRejection->id()->value(), $billData);
    }
}
