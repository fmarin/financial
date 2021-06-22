<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Shared\Domain\CoRAbstractHandler;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\ProcessStatus;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionValidationChain\PaidWithoutExistingBillHandler;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionValidationChain\PaidWithExistingBillHandler;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionValidationChain\UnpaidWithoutExistingBillHandler;
use Financial\Unpaid\Devolutions\Domain\DevolutionValidatedToUpdateStatusDomainEventFactory;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class PendingOfInsertDevolutionHandler extends CoRAbstractHandler
{
    private DebtRejection $debtRejection;
    private Bancara $domiciliation;
    private int $devolutionExists;
    private EventBus $bus;

    public function __construct(
        DebtRejection $debtRejection,
        Bancara $domiciliation,
        int $devolutionExists,
        EventBus $bus
    )
    {
        $this->debtRejection = $debtRejection;
        $this->domiciliation = $domiciliation;
        $this->devolutionExists = $devolutionExists;
        $this->bus = $bus;
    }

    public function handle()
    {
        var_dump('THIRD VALIDATION');

        if(
            $this->debtRejection->internalId()->isNumeric() &&
            !$this->domiciliation->id()->isEmpty() && !$this->devolutionExists
        ){
            $firstPaidValidation = new PaidWithoutExistingBillHandler($this->debtRejection, $this->domiciliation, $this->bus);
            $secondPaidValidation = new UnpaidWithoutExistingBillHandler($this->debtRejection, $this->domiciliation, $this->bus);
            $thirdPaidValidation = new PaidWithExistingBillHandler($this->debtRejection, $this->domiciliation, $this->bus);

            $firstPaidValidation->setNext($secondPaidValidation);
            $secondPaidValidation->setNext($thirdPaidValidation);
            $firstPaidValidation->handle();

        }else{
            $devolutionValidatedToUpdateStatusDomainEvent = DevolutionValidatedToUpdateStatusDomainEventFactory::create(
                $this->debtRejection->id()->value(),
                ProcessStatus::DEVOLUTION_CREATED_BEFORE
            );

            $this->bus->publish(...[$devolutionValidatedToUpdateStatusDomainEvent]);
        }
    }
}