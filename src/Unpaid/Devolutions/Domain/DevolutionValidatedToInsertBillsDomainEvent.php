<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DevolutionValidatedToInsertBillsDomainEvent extends DomainEvent
{
    private array $billData;

    public function __construct(
        string $id,
        array $billData,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->billData = $billData;
    }

    public static function eventName(): string
    {
        return 'devolution.validated';
    }

    public function toPrimitives(): array
    {
        return $this->billData;
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
