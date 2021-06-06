<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\Bus\Event\DomainEvent;

final class DebtRejectionCreatedDomainEvent extends DomainEvent
{
    private DebtRejection $debtRejection;

    public function __construct(
        string $id,
        DebtRejection $debtRejection,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
        $this->debtRejection = $debtRejection;
    }

    public static function eventName(): string
    {
        return 'debt.rejection.created';
    }

    public function toPrimitives(): array
    {
        return [
            'bankFileName' => $this->debtRejection->BankFileName()->value(),
            'creationDateTime' => $this->debtRejection->CreationDateTime()->value(),
            'refundId' => $this->debtRejection->RefundId()->value(),
            'internalId' => $this->debtRejection->InternalId()->value(),
            'transactionStatus' => $this->debtRejection->TransactionStatus()->value(),
            'statusReasonCode' => $this->debtRejection->StatusReasonCode()->value(),
            'debtAmount' => $this->debtRejection->DebtAmount()->value(),
            'paymentDate' => $this->debtRejection->PaymentDate()->value(),
            'debtorAccount' => $this->debtRejection->DebtorAccount()->value(),
            'creditorAccount' => $this->debtRejection->CreditorAccount()->value(),
            'debtorName' => $this->debtRejection->DebtorName()->value(),
            'processStatus' => $this->debtRejection->ProcessStatus()->value()
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
            DebtRejectionFactory::create($body),
            $eventId,
            $occurredOn
        );
    }
}
