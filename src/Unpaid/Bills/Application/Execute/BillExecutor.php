<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Application\Execute;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\Bills\Domain\BillRepository;

final class BillExecutor
{
    private BillRepository $repository;
    private EventBus $bus;

    public function __construct(BillRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function __invoke($billData)
    {
        dump('EXECUTE PROCEDURE BILL');

        $this->repository->execute($billData);
    }
}