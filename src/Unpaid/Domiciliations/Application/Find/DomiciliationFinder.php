<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Application\Find;

use Financial\Unpaid\Domiciliations\Domain\Bancara;
use Financial\Unpaid\Domiciliations\Domain\DomiciliationRepository;

final class DomiciliationFinder
{
    private DomiciliationRepository $repository;

    public function __construct(DomiciliationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($refundId, $internalId): Bancara
    {
        return $this->repository->search([$refundId, $internalId]);
    }
}
