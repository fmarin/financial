<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Shared\Infrastructure\Doctrine;

use Financial\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

final class UnpaidEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../databases/unpaid.sql';

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes               = DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Unpaid', 'Financial\Unpaid');
        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../Unpaid', 'Unpaid');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            self::SCHEMA_PATH,
            $dbalCustomTypesClasses
        );
    }
}
