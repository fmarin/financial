<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

final class DevolutionValidatedToInsertBillsDomainEventFactory
{
    public static function create(string $aggregateId, string $status): DevolutionValidatedToInsertBillsDomainEvent
    {
        return new DevolutionValidatedToInsertBillsDomainEvent($aggregateId, $status);
    }
}
