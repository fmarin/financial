<?php

declare(strict_types=1);

namespace Financial\Unpaid\Devolutions\Application\Find;

use Financial\Unpaid\Devolutions\Domain\DevolutionRepository;

final class DevolutionExists
{
    private DevolutionRepository $repository;

    public function __construct(DevolutionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($refundId, $internalId): int
    {
        return $this->repository->existsByRefundId([$refundId, $internalId]);
    }
}
