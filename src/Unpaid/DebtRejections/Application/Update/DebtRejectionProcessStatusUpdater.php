<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Application\Update;

use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;

final class DebtRejectionProcessStatusUpdater
{
    private DebtRejectionRepository $repository;

    public function __construct(DebtRejectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Uuid $id, ProcessStatus $status)
    {
        $debtRejection = $this->repository->search($id);

        $debtRejection->setProcessStatus($status);

        $this->repository->save($debtRejection);
    }
}