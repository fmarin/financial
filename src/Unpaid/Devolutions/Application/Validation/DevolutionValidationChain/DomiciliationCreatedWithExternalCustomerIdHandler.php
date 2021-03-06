<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedDomainEventFactory;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateStatusDomainEventFactory;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DomiciliationCreatedWithExternalCustomerIdHandler extends CoRAbstractHandler
{
    const INSERT_TYPE = 5;

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
        dump('-----------------------------------------------------------');
        dump('FIRST VALIDATION');

        if(!$this->debtRejection->internalId()->isNumeric() && !$this->devolutionExistsWithClient){
            dump("PUBLISH INSERT IN bancara_devol");
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

        $updateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
            $this->debtRejection->id()->value(),
            ProcessStatus::DEVOLUTION_CREATED_WITH_EXTERNAL_CUSTOMER_ID
        );

        return [$devolutionValidatedDomainEvent, $updateStatusDomainEvent];
    }
}