<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Infrastructure\Persistence;

use Financial\Shared\Infrastructure\Persistence\Doctrine\DoctrineDbal;
use Financial\Unpaid\Domiciliations\Domain\Bancara;
use Financial\Unpaid\Domiciliations\Domain\DomiciliationRepository;
use Financial\Unpaid\Domiciliations\Domain\BankId;
use Financial\Unpaid\Domiciliations\Domain\BillId;
use Financial\Unpaid\Domiciliations\Domain\Id;
use Financial\Unpaid\Domiciliations\Domain\Incasat;
use Financial\Unpaid\Domiciliations\Domain\Status;
use Financial\Unpaid\Domiciliations\Domain\Type;

final class LegacyDomiciliationRepository extends DoctrineDbal implements DomiciliationRepository
{
    public function search($params = []): Bancara
    {
        $sql = <<<SQL
            SELECT 
                isnull(db.incasat,0) incasat,
                db.status,
                b.id_bill,
                db.id_domiciliere, 
                db.type,
                db.id_bank            
            FROM domiciliere_bancara_test db
            LEFT JOIN bills_test b
                ON b.id_direct_debit = db.id_domiciliere
            WHERE db.id_refund = :refundId
              AND db.internal_id = :internalId
SQL;

        $bancaraData = $this->fetchAll($sql, $params);

        if(count($bancaraData) === 0){
            return Bancara::create(
                new Id(0),
                new BankId(0),
                new BillId(0),
                new Incasat(0),
                new Status(0),
                new Type(0)
            );
        }

        $bancaraData = $bancaraData[0];

        return Bancara::create(
            new Id((int) $bancaraData['id_domiciliere']),
            new BankId((int) $bancaraData['id_bank']),
            new BillId((int) $bancaraData['id_bill']),
            new Incasat((int) $bancaraData['incasat']),
            new Status((int) $bancaraData['status']),
            new Type((int) $bancaraData['type'])
        );
    }

    public function update($params = []): void
    {
        $sql = <<<SQL
            UPDATE [WORK].[dbo].[domiciliere_bancara_test]
            SET status = :status
            WHERE id_refund = :refundId 
              AND internal_id = :internalId
SQL;

        $this->executeUpdate($sql, $params);
    }
}
