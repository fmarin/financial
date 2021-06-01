<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\Uuid;

interface DebtRejectionRepository
{
    public function save(DebtRejection $debtRejection): void;

    public function search(Uuid $id): ?DebtRejection;
}
