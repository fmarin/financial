<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Domain;

interface DevolutionRepository
{
    public function existsByRefundId($params = []): int;

    public function existsByInternalId($params = []): int;

    public function save(): void;
}
