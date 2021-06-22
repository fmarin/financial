<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Application\Validation\PrepareDataToSend\DevolutionPreparatorFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEventFactory;
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
        var_dump('BLOCK TWO');

        if($this->domiciliation->billId()->isEmpty() && !$this->domiciliation->incasat()->value()){
            var_dump("PUBLISH INSERT/UPDATE IN bancara_devol, bancara");

            $devolutionPreparator = DevolutionPreparatorFactory::create(
                $this->debtRejection,
                $this->domiciliation,
                self::INSERT_TYPE
            );

            $devolutionValidatedDomainEvent = DevolutionValidatedDomainEventFactory::create(
                $this->debtRejection->id()->value(),
                $devolutionPreparator->__invoke()
            );

            // TODO: CREATE DOMEIN EVENT TO UPDATE BANCARA TABLE

            $devolutionValidatedToUpdateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
                $this->debtRejection->id()->value(),
                ProcessStatus::DEVOLUTION_CREATED_OK
            );

            $this->bus->publish(...[
                $devolutionValidatedDomainEvent,
                $devolutionValidatedToUpdateStatusDomainEvent
            ]);

        }else{
            return $this->next();
        }
    }
}