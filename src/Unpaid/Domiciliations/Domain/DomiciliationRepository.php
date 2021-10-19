<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Domain;

interface DomiciliationRepository
{
    public function search($params = []): ?Bancara;

    public function update($params = []): void;
}


