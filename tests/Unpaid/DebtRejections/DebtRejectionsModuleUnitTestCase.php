<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections;

use Financial\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionRepository;
use Mockery\MockInterface;
use Ramsey\Uuid\Uuid;

abstract class DebtRejectionsModuleUnitTestCase extends UnitTestCase
{
    private ?MockInterface $repository = null;

    protected function shouldSave(DebtRejection $debtRejection): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($debtRejection)
            ->andReturnNull();
    }

    /** @return DebtRejectionRepository|MockInterface */
    protected function repository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(DebtRejectionRepository::class);
    }
}
