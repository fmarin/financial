<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Create;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionFactory;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;

final class DebtRejectionCreator
{
    private DebtRejectionRepository $repository;
    private EventBus $bus;

    public function __construct(DebtRejectionRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke($data)
    {
        $debtRejection = DebtRejectionFactory::create($data);

        $this->repository->save($debtRejection);
        $this->bus->publish(...$debtRejection->pullDomainEvents());
    }
}