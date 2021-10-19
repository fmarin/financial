<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Infrastructure;

use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;

class InMemoryRepository implements DebtRejectionRepository
{
    private array $debtRejections = [];

    public function save(DebtRejection $debtRejection): void
    {
        $this->debtRejections[$debtRejection->id()->value()] = $debtRejection;
    }

    public function search(Uuid $id): ?DebtRejection
    {
        return ($this->debtRejections[$id->value()]) ?? $this->debtRejections[$id->value()];
    }
}