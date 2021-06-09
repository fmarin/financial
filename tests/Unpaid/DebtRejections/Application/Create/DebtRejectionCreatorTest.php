<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Application\Create;

use Financial\Tests\Unpaid\DebtRejections\DebtRejectionsModuleUnitTestCase;
use Financial\Tests\Unpaid\DebtRejections\Domain\DebtRejectionCreatedDomainEventMother;
use Financial\Tests\Unpaid\DebtRejections\Domain\DebtRejectionMother;
use Financial\Unpaid\DebtRejections\Application\Create\DebtRejectionCreator;

final class DebtRejectionCreatorTest extends DebtRejectionsModuleUnitTestCase
{
    private DebtRejectionCreator $creator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = new DebtRejectionCreator($this->repository(), $this->eventBus());
    }

    /** @test */
    public function it_should_create_a_debt_rejection(): void
    {
        $dataForCreation = DebtRejectionMother::getRowDataForCreation();
        $debtRejection = DebtRejectionMother::create();
        $domainEvent = DebtRejectionCreatedDomainEventMother::create($debtRejection);

        $this->shouldSave($debtRejection);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->creator->__invoke($dataForCreation);
    }
}
