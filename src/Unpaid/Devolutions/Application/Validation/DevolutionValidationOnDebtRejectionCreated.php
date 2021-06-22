<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation;

use Financial\Unpaid\DebtRejections\Domain\DebtRejectionCreatedDomainEvent;
use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionFactory;

final class DevolutionValidationOnDebtRejectionCreated implements DomainEventSubscriber
{
    private DevolutionValidation $devolutionValidation;

    public function __construct(DevolutionValidation $devolutionValidation)
    {
        $this->devolutionValidation = $devolutionValidation;
    }

    public static function subscribedTo(): array
    {
        return [DebtRejectionCreatedDomainEvent::class];
    }

    public function __invoke(DebtRejectionCreatedDomainEvent $event): void
    {
        $debtRejection = DebtRejectionFactory::create($event->toPrimitives());

        $this->devolutionValidation->__invoke($debtRejection);
    }
}
