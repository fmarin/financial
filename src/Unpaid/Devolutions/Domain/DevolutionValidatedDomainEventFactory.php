<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

final class DevolutionValidatedDomainEventFactory
{
    public static function create(string $aggregateId, array $devolutionData): DevolutionValidatedDomainEvent
    {
        return new DevolutionValidatedDomainEvent($aggregateId, $devolutionData);
    }
}
