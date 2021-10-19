<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;

final class DevolutionValidatedToUpdateDomiciliationStatusDomainEventFactory
{
    const STATE_RETURNED = 2;

    public static function create(DebtRejection $debtRejection): DevolutionValidatedToUpdateDomiciliationStatusDomainEvent
    {
        $domiciliationData = [
            'id' => $debtRejection->id(),
            'refundId' => $debtRejection->refundId()->value(),
            'internalId' => $debtRejection->internalId()->value(),
            'status' => self::STATE_RETURNED
        ];

        return new DevolutionValidatedToUpdateDomiciliationStatusDomainEvent($debtRejection->id()->value(), $domiciliationData);
    }
}
