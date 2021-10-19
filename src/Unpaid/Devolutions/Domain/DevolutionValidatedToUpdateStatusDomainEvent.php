<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DevolutionValidatedToUpdateStatusDomainEvent extends DomainEvent
{
    private string $status;

    public function __construct(
        string $id,
        string $status,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->status = $status;
    }

    public static function eventName(): string
    {
        return 'devolution.validated.to.update.status';
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->aggregateId(),
            'status' => $this->status
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $body['status'],
            $eventId,
            $occurredOn
        );
    }
}
