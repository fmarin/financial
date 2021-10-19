<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Application\Create;

use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToInsertBillsDomainEvent;

final class BillCreateOnDevolutionValidated implements DomainEventSubscriber
{
    private BillCreator $creator;

    public function __construct(BillCreator $creator)
    {
        $this->creator = $creator;
    }

    public static function subscribedTo(): array
    {
        return [DevolutionValidatedToInsertBillsDomainEvent::class];
    }

    public function __invoke(DevolutionValidatedToInsertBillsDomainEvent $event): void
    {
        $billData = $event->toPrimitives();

        $this->creator->__invoke($billData);
    }
}
