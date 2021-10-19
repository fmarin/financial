<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

final class DevolutionValidatedToUpdateStatusDomainEventFactory
{
    public static function create(string $aggregateId, string $status): DevolutionValidatedToUpdateStatusDomainEvent
    {
        return new DevolutionValidatedToUpdateStatusDomainEvent($aggregateId, $status);
    }
}
