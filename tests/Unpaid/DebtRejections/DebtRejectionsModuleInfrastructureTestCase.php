<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections;

use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;
use Financial\Tests\Unpaid\Shared\Infrastructure\PhpUnit\UnpaidContextInfrastructureTestCase;

abstract class DebtRejectionsModuleInfrastructureTestCase extends UnpaidContextInfrastructureTestCase
{
    protected function repository(): DebtRejectionRepository
    {
        return $this->service(DebtRejectionRepository::class);
    }
}
