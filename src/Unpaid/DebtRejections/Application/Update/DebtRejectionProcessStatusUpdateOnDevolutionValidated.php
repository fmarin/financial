<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Update;

use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateStatusDomainEvent;

final class DebtRejectionProcessStatusUpdateOnDevolutionValidated implements DomainEventSubscriber
{
    private DebtRejectionProcessStatusUpdater $updater;

    public function __construct(DebtRejectionProcessStatusUpdater $updater)
    {
        $this->updater = $updater;
    }

    public static function subscribedTo(): array
    {
        return [DevolutionValidatedToUpdateStatusDomainEvent::class];
    }

    public function __invoke(DevolutionValidatedToUpdateStatusDomainEvent $event): void
    {
        $dataToUpdate = $event->toPrimitives();

        $debtRejectionId = new Uuid($dataToUpdate['id']);
        $processStatus = new ProcessStatus((int) $dataToUpdate['status']);

        $this->updater->__invoke($debtRejectionId, $processStatus);
    }
}
