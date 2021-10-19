<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Create;

use Financial\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEvent;

final class DevolutionCreateOnDevolutionValidated implements DomainEventSubscriber
{
    private DevolutionCreator $creator;

    public function __construct(DevolutionCreator $creator)
    {
        $this->creator = $creator;
    }

    public static function subscribedTo(): array
    {
        return [DevolutionValidatedDomainEvent::class];
    }

    public function __invoke(DevolutionValidatedDomainEvent $event): void
    {
        $devolutionData = $event->toPrimitives();

        $this->creator->__invoke($devolutionData);
    }
}
