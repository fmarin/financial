<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Application\Update;

use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateDomiciliationStatusDomainEvent;

final class DomiciliationStatusUpdateOnDevolutionValidated implements DomainEventSubscriber
{
    private DomiciliationStatusUpdater $updater;

    public function __construct(DomiciliationStatusUpdater $updater)
    {
        $this->updater = $updater;
    }

    public static function subscribedTo(): array
    {
        return [DevolutionValidatedToUpdateDomiciliationStatusDomainEvent::class];
    }

    public function __invoke(DevolutionValidatedToUpdateDomiciliationStatusDomainEvent $event): void
    {
        $dataToUpdate = $event->toPrimitives();

        $this->updater->__invoke($dataToUpdate);
    }
}
