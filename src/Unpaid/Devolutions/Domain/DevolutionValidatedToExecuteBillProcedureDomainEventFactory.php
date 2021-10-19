<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DevolutionValidatedToExecuteBillProcedureDomainEventFactory
{
    public static function create(DebtRejection $debtRejection, Bancara $domiciliation): DevolutionValidatedToExecuteBillProcedureDomainEvent
    {
        $dataForProcedure = [
            'id' => $debtRejection->id(),
            'billId' => $domiciliation->billId()->value(),
            'creationDateTime' => $debtRejection->creationDateTime()->value(),
            'type' => $domiciliation->type()->value(),
            'date' => $debtRejection->CreationDateTime()->getDateToBill(),
            'value' => $debtRejection->debtAmount()->value(),
            'statusReasonCode' => $debtRejection->statusReasonCode()->value(),
            'clientId' => $debtRejection->internalId()->value(),
            'bankId' => $domiciliation->bankId()->value(),
            'localUser' => 123456, // TODO: SET THE USER THAT EXECUTE THE PROCESS
        ];

        return new DevolutionValidatedToExecuteBillProcedureDomainEvent($debtRejection->id()->value(), $dataForProcedure);
    }
}
