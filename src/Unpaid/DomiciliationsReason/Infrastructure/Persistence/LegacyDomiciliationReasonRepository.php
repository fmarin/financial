<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DomiciliationsReason\Infrastructure\Persistence;

use Financial\Shared\Infrastructure\Persistence\Doctrine\DoctrineDbal;
use Financial\Unpaid\DomiciliationsReason\Domain\BancaraMotiv;
use Financial\Unpaid\DomiciliationsReason\Domain\Code;
use Financial\Unpaid\DomiciliationsReason\Domain\DomiciliationReasonRepository;
use Financial\Unpaid\DomiciliationsReason\Domain\Id;
use Financial\Unpaid\DomiciliationsReason\Domain\Reason;

final class LegacyDomiciliationReasonRepository extends DoctrineDbal implements DomiciliationReasonRepository
{
    public function search($params = []): BancaraMotiv
    {
        $sql = <<<SQL
            SELECT *
            FROM [WORK].[dbo].[domiciliere_bancara_motiv_test]
            WHERE id_motiv_code = :statusReasonCode
SQL;

        $bancaraMotivData = $this->fetchAll($sql, $params);

        if(count($bancaraMotivData) === 0){
            return BancaraMotiv::create(
                new Id(0),
                new Code(''),
                new Reason('')
            );
        }

        $bancaraMotivData = $bancaraMotivData[0];

        return BancaraMotiv::create(
            new Id((int) $bancaraMotivData['id_motiv']),
            new Code($bancaraMotivData['id_motiv_code']),
            new Reason($bancaraMotivData['motiv'])
        );
    }
}
