<?php

declare(strict_types = 1);

namespace Financial\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;

abstract class DoctrineDbal
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    protected function connection(): Connection
    {
        return $this->connection;
    }

    public function fetchAll($sql, $params = []): array
    {
        return $this->connection->fetchAll($sql, $params);
    }

    public function executeUpdate($sql, $params = [])
    {
        try {
            return $this->connection->executeUpdate($sql, $params);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function executeQuery($sql, $params = [])
    {
        try {
            return $this->connection->executeQuery($sql, $params);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
}
