<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Application\Create;

use Financial\Tests\Unpaid\DebtRejections\DebtRejectionsModuleUnitTestCase;
use Financial\Tests\Unpaid\DebtRejections\Domain\DebtRejectionMother;

final class DebtRejectionMultipleCreatorTest extends DebtRejectionsModuleUnitTestCase
{
    /** @test */
    public function it_should_create_a_debt_rejection(): void
    {
        $debtRejection = DebtRejectionMother::random();
        $this->shouldSave($debtRejection);
    }
}
