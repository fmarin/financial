<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Infrastructure\Persistence;

use Financial\Shared\Infrastructure\Persistence\Doctrine\DoctrineDbal;
use Financial\Unpaid\Devolutions\Domain\DevolutionRepository;

final class LegacyDevolutionRepository extends DoctrineDbal implements DevolutionRepository
{
    public function existsByRefundId($params = []): int
    {
        $sql = <<<SQL
            SELECT
                CASE
                    WHEN COUNT(1) = 0 THEN 0
                    ELSE 1
                END AS exist
            FROM domiciliere_bancara_devol_test dbd
            WHERE dbd.id_refund = :refundId + :internalId
SQL;

        $exists = $this->fetchAll($sql, $params);

        return (int) $exists[0]['exist'];
    }

    public function existsByInternalId($params = []): int
    {
        $sql = <<<SQL
            SELECT
                CASE
                    WHEN COUNT(1) = 0 THEN 0
                    ELSE 1
                END AS exist
            FROM domiciliere_bancara_devol_test dbd
            WHERE dbd.id_client = :internalId
              AND CAST(dbd.date_created AS DATE) = CAST(:creationDateTime AS DATE)
              AND CAST(dbd.date_charge AS DATE)  = CAST(:paymentDate AS DATE)
SQL;

        $exists = $this->fetchAll($sql, $params);

        return (int) $exists[0]['exist'];
    }

    public function save(): void
    {

    }
}
