<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Application\Validation\PrepareDataToSend\DevolutionPreparatorFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEventFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToInsertBillsDomainEvent;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateStatusDomainEventFactory;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class WithoutDomiciliationByOldFormatHandler extends CoRAbstractHandler
{
    const INSERT_TYPE = 4;

    private DebtRejection $debtRejection;
    private Bancara $domiciliation;
    private int $devolutionExistsWithClient;
    private EventBus $bus;

    public function __construct(
        DebtRejection $debtRejection,
        Bancara $domiciliation,
        int $devolutionExistsWithClient,
        EventBus $bus
    )
    {
        $this->debtRejection = $debtRejection;
        $this->domiciliation = $domiciliation;
        $this->devolutionExistsWithClient = $devolutionExistsWithClient;
        $this->bus = $bus;
    }

    public function handle()
    {
        var_dump('SECOND VALIDATION');

        if(
            $this->debtRejection->internalId()->isNumeric() &&
            $this->domiciliation->id()->isEmpty() && !$this->devolutionExistsWithClient
        ){
            var_dump("PUBLISH INSERT IN bancara_devol && bill && bill_load");

            $devolutionPreparator = DevolutionPreparatorFactory::create(
                $this->debtRejection,
                $this->domiciliation,
                self::INSERT_TYPE
            );

            $devolutionValidatedDomainEvent = DevolutionValidatedDomainEventFactory::create(
                $this->debtRejection->id()->value(),
                $devolutionPreparator->__invoke()
            );

            $devolutionValidatedToInsertBillsDomainEvent = new DevolutionValidatedToInsertBillsDomainEvent(
                $this->debtRejection->id()->value(),
                $this->debtRejection
            );

            $devolutionValidatedToUpdateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
                $this->debtRejection->id()->value(),
                ProcessStatus::DEVOLUTION_CREATED_WITHOUT_DOMICILIATION_BY_OLD_FORMAT
            );

            $this->bus->publish(...[
                $devolutionValidatedDomainEvent,
                $devolutionValidatedToInsertBillsDomainEvent,
                $devolutionValidatedToUpdateStatusDomainEvent
            ]);

        }else{
            return $this->next();
        }
    }
}