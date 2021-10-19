<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\Shared\Infrastructure\PhpUnit;

use Financial\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

abstract class UnpaidContextInfrastructureTestCase extends InfrastructureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $arranger = new UnpaidEnvironmentArranger($this->service(EntityManager::class));

        $arranger->arrange();
    }

    protected function tearDown(): void
    {
        $arranger = new UnpaidEnvironmentArranger($this->service(EntityManager::class));

        $arranger->close();

        parent::tearDown();
    }
}
