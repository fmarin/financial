<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Infrastructure\Persistence;

use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Tests\Unpaid\DebtRejections\DebtRejectionsModuleInfrastructureTestCase;
use Financial\Tests\Unpaid\DebtRejections\Domain\DebtRejectionMother;

final class DebtRejectionRepositoryTest extends DebtRejectionsModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_debt_rejection(): void
    {
        $debtRejection = DebtRejectionMother::create();

        $this->repository()->save($debtRejection);
    }

    /** @test */
    public function it_should_return_an_existing_debt_rejection(): void
    {
        $debtRejection = DebtRejectionMother::create();

        $this->repository()->save($debtRejection);

        $this->assertEquals($debtRejection, $this->repository()->search($debtRejection->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_debt_rejection(): void
    {
        $this->assertNull($this->repository()->search(Uuid::random()));
    }
}
