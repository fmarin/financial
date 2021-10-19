<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DevolutionValidatedToUpdateDomiciliationStatusDomainEvent extends DomainEvent
{
    private array $domiciliationData;

    public function __construct(
        string $id,
        array $domiciliationData,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->domiciliationData = $domiciliationData;
    }

    public static function eventName(): string
    {
        return 'devolution.validated.to.update.domiciliation.status';
    }

    public function toPrimitives(): array
    {
        return $this->domiciliationData;
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
