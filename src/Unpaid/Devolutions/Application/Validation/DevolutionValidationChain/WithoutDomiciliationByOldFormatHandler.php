<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEventFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToInsertBillsDomainEventFactory;
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
        dump('SECOND VALIDATION');

        if(
            $this->debtRejection->internalId()->isNumeric() &&
            $this->domiciliation->id()->isEmpty() && !$this->devolutionExistsWithClient
        ){
            dump("PUBLISH INSERT IN bancara_devol && bill && bill_load");
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

        $insertBillsDomainEvent = DevolutionValidatedToInsertBillsDomainEventFactory::create(
            $this->debtRejection,
            $this->domiciliation->bankId()
        );

        $updateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
            $this->debtRejection->id()->value(),
            ProcessStatus::DEVOLUTION_CREATED_WITHOUT_DOMICILIATION_BY_OLD_FORMAT
        );

        return [$devolutionValidatedDomainEvent, $insertBillsDomainEvent, $updateStatusDomainEvent];
    }
}