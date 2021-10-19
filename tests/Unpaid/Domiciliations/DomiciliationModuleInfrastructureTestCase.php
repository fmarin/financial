<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\Domiciliations;

use Financial\Tests\Unpaid\Shared\Infrastructure\PhpUnit\UnpaidContextInfrastructureTestCase;
use Financial\Unpaid\Domiciliations\Domain\DomiciliationRepository;

abstract class DomiciliationModuleInfrastructureTestCase extends UnpaidContextInfrastructureTestCase
{
    protected function repository(): DomiciliationRepository
    {
        return $this->service(DomiciliationRepository::class);
    }
}
