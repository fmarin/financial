<?php

declare(strict_types = 1);

namespace Financial\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;

abstract class DoctrineDbal
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll($sql, $params = []): array
    {
        return $this->connection->fetchAll($sql, $params);
    }
}
