<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DevolutionValidatedToExecuteBillProcedureDomainEvent extends DomainEvent
{
    private array $dataForProcedure;

    public function __construct(
        string $id,
        array $dataForProcedure,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->dataForProcedure = $dataForProcedure;
    }

    public static function eventName(): string
    {
        return 'devolution.validated.to.execute.bill.procedure';
    }

    public function toPrimitives(): array
    {
        return $this->dataForProcedure;
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
