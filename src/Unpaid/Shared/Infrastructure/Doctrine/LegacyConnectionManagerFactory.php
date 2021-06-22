<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

final class LegacyConnectionManagerFactory
{
    public static function create(array $parameters): Connection
    {
        return DriverManager::getConnection($parameters);
    }
}
