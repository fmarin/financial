<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DomiciliationsReason\Application\Find;

use Financial\Unpaid\DomiciliationsReason\Domain\BancaraMotiv;
use Financial\Unpaid\DomiciliationsReason\Domain\DomiciliationReasonRepository;

final class DomiciliationReasonFinder
{
    private DomiciliationReasonRepository $repository;

    public function __construct(DomiciliationReasonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($statusReasonCode): BancaraMotiv
    {
        return $this->repository->search([$statusReasonCode]);
    }
}
