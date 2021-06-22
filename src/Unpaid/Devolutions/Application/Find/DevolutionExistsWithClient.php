<?php

declare(strict_types=1);

namespace Financial\Unpaid\Devolutions\Application\Find;

use Financial\Unpaid\Devolutions\Domain\DevolutionRepository;

final class DevolutionExistsWithClient
{
    private DevolutionRepository $repository;

    public function __construct(DevolutionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($internalId, $creationDateTime, $chargeDate): int
    {
        return $this->repository->existsByInternalId([$internalId, $creationDateTime, $chargeDate]);
    }
}
