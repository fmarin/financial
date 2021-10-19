<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Infrastructure\Persistence;

use Financial\Shared\Infrastructure\Persistence\Doctrine\DoctrineDbal;
use Financial\Unpaid\Bills\Domain\BillRepository;

final class LegacyBillRepository extends DoctrineDbal implements BillRepository
{
    public function saveBillAndBillLoad($params = []): void
    {
        $conn = $this->connection();
        $conn->beginTransaction();

        try{
            $sqlInsertBill = <<<SQL
                INSERT INTO [WORK].[dbo].[bills_test](
                    id_client,
                    id_branch,
                    id_casa,
                    id_doc_type,
                    id_bank,
                    bank_type,
                    sn,
                    number,
                    date,
                    value,
                    ciel,
                    socrate,
                    status,
                    obs_anul,
                    id_user_insert,
                    id_user_update,
                    date_insert,
                    date_update,
                    value_ROL,
                    id_parent,
                    HOSTNAME,
                    USERNAME,
                    id_row,
                    type,
                    obs,
                    id_direct_debit
                ) VALUES (
                    :clientId, 
                    1, 
                    NULL, 
                    13, 
                    :bankId, 
                    0, 
                    NULL, 
                    :number, 
                    :date, 
                    :value, 
                    0, 
                    0, 
                    1, 
                    'Anulare devolucion DD', 
                    :localUser, 
                    :localUser, 
                    GETDATE(), 
                    GETDATE(), 
                    NULL, 
                    NULL, 
                    'FINANCIAL-UNPAID-MICROSERVICE', 
                    'rdsdbbuc', 
                    NEWID(), 
                    3, 
                    :reason, 
                    NULL
                )
SQL;

            $this->executeUpdate($sqlInsertBill, $params);

            $billId = $conn->lastInsertId();
            $params['billId'] = $billId;

            $sqlInsertBillLoad = <<<SQL
                INSERT INTO [WORK].[dbo].[bills_load_test](
                    id_bill,
                    id_subcont,
                    id_load,
                    description,
                    value,
                    id_user_insert,
                    id_user_update,
                    date_insert,
                    date_update,
                    overload,
                    value_ROL,
                    HOSTNAME,
                    USERNAME,
                    id_row,
                    id_seller
                ) VALUES (
                    :billId,
                    0,
                    NULL,
                    'Contravaloarea a Descripcion ' + :value + ' euro inregistrati ca devolutie DD',
                    :value,
                    :localUser,
                    :localUser,
                    GETDATE(),
                    GETDATE(),
                    0,
                    NULL,
                    'FINANCIAL-UNPAID-MICROSERVICE',
                    'rdsdbbuc',
                    NEWID(),
                    4
                )
SQL;

            $this->executeUpdate($sqlInsertBillLoad, $params);

            $conn->commit();
        } catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function execute($params = []): void
    {
        $sql = <<<SQL
            EXEC [WORK].[dbo].[usp_directDebitDevolutii_test] 
                :billId,
                :creationDateTime,
                :type,
                :date,
                :value,
                :statusReasonCode,
                :clientId,
                :bankId,
                :localUser
SQL;

        $this->executeQuery($sql, $params);
    }
}
