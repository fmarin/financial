<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEventFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateDomiciliationStatusDomainEventFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateStatusDomainEventFactory;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class UnpaidWithoutExistingBillHandler extends CoRAbstractHandler
{
    const INSERT_TYPE = 2;

    private DebtRejection $debtRejection;
    private Bancara $domiciliation;
    private EventBus $bus;

    public function __construct(DebtRejection $debtRejection, Bancara $domiciliation, EventBus $bus)
    {
        $this->debtRejection = $debtRejection;
        $this->domiciliation = $domiciliation;
        $this->bus = $bus;
    }

    public function handle()
    {
        dump('BLOCK TWO');

        if($this->domiciliation->billId()->isEmpty() && !$this->domiciliation->incasat()->value()){
            dump("PUBLISH INSERT/UPDATE IN bancara_devol, bancara");
            $this->bus->publish(...$this->getDomainEventsToPublish());

        }else{
            return $this->next();
        }
    }

    private function getDomainEventsToPublish(): array
    {
        $devolutionValidatedDomainEvent = DevolutionValidatedDomainEventFactory::create(
            $this->debtRejection,
            $this->domiciliation,
            self::INSERT_TYPE
        );

        $updateDomiciliationStatusDomainEvent = DevolutionValidatedToUpdateDomiciliationStatusDomainEventFactory::create(
            $this->debtRejection
        );

        $updateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
            $this->debtRejection->id()->value(),
            ProcessStatus::DEVOLUTION_CREATED_OK
        );

        return [$devolutionValidatedDomainEvent, $updateDomiciliationStatusDomainEvent, $updateStatusDomainEvent];
    }
}