<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Create;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\Devolutions\Domain\DevolutionRepository;

final class DevolutionCreator
{
    private DevolutionRepository $repository;
    private EventBus $bus;

    public function __construct(DevolutionRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke($devolutionData)
    {
        // TODO: PREPARE DATA TO SAVE

//        $this->repository->save();

        // TODO: CREATE DOMAIN EVENT TO UNPAID-PREPARE

//        $this->bus->publish(...[]);
    }
}