<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Infrastructure\Persistence;

use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;
use Financial\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineDebtRejectionRepository extends DoctrineRepository implements DebtRejectionRepository
{
    public function save(DebtRejection $debtRejection): void
    {
        $this->persist($debtRejection);
    }

    public function search(Uuid $id): ?DebtRejection
    {
        return $this->repository(DebtRejection::class)->find($id);
    }
}
