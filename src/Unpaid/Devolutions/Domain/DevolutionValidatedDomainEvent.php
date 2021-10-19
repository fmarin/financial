<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DevolutionValidatedDomainEvent extends DomainEvent
{
    private array $devolutionData;

    public function __construct(
        string $id,
        array $devolutionData,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->devolutionData = $devolutionData;
    }

    public static function eventName(): string
    {
        return 'devolution.validated';
    }

    public function toPrimitives(): array
    {
        return $this->devolutionData;
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body,
            $eventId,
            $occurredOn
        );
    }
}
