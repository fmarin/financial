<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\Shared\Infrastructure\PhpUnit;

use Financial\Tests\Shared\Infrastructure\Arranger\EnvironmentArranger;
use Financial\Tests\Shared\Infrastructure\Doctrine\DatabaseCleaner;
use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\apply;

final class UnpaidEnvironmentArranger implements EnvironmentArranger
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function arrange(): void
    {
        apply(new DatabaseCleaner(), [$this->entityManager]);
    }

    public function close(): void
    {
    }
}
