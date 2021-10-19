<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Application\Update;

use Financial\Unpaid\Domiciliations\Domain\DomiciliationRepository;

final class DomiciliationStatusUpdater
{
    private DomiciliationRepository $repository;

    public function __construct(DomiciliationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $dataToUpdate)
    {
        dump('UPDATE BANCARA STATUS');

        $this->repository->update($dataToUpdate);
    }
}