<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure\PhpUnit;

use Financial\Tests\Unpaid\Shared\Infrastructure\PhpUnit\UnpaidEnvironmentArranger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class InfrastructureTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);

        parent::setUp();

        // @todo This should be for the "Shared Infrastructure" connection
        $arranger = new UnpaidEnvironmentArranger($this->service(EntityManager::class));

        $arranger->arrange();
    }

    /** @return mixed */
    protected function service($id)
    {
        return self::$container->get($id);
    }

    /** @return mixed */
    protected function parameter($parameter)
    {
        return self::$container->getParameter($parameter);
    }
}
