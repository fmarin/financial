<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Application\Execute;

use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToExecuteBillProcedureDomainEvent;

final class BillExecuteOnDevolutionValidated implements DomainEventSubscriber
{
    private BillExecutor $executor;

    public function __construct(BillExecutor $executor)
    {
        $this->executor = $executor;
    }

    public static function subscribedTo(): array
    {
        return [DevolutionValidatedToExecuteBillProcedureDomainEvent::class];
    }

    public function __invoke(DevolutionValidatedToExecuteBillProcedureDomainEvent $event): void
    {
        $dataForProcedure = $event->toPrimitives();

        $this->executor->__invoke($dataForProcedure);
    }
}
