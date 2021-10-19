<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Devolutions\Application\Find\DevolutionExists;
use Financial\Unpaid\Devolutions\Application\Find\DevolutionExistsWithClient;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\PendingOfInsertDevolutionHandler;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\WithoutDomiciliationByOldFormatHandler;
use Financial\Unpaid\Devolutions\Application\Validation\DevolutionValidationChain\DomiciliationCreatedWithExternalCustomerIdHandler;
use Financial\Unpaid\Domiciliations\Application\Find\DomiciliationFinder;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DevolutionValidation
{
    private DomiciliationFinder $domiciliationFinder;
    private DevolutionExists $devolutionExists;
    private DevolutionExistsWithClient $devolutionExistsWithClient;
    private EventBus $bus;

    public function __construct(
        DomiciliationFinder $domiciliationFinder,
        DevolutionExists $devolutionExists,
        DevolutionExistsWithClient $devolutionExistsWithClient,
        EventBus $bus
    )
    {
        $this->domiciliationFinder = $domiciliationFinder;
        $this->devolutionExists = $devolutionExists;
        $this->devolutionExistsWithClient = $devolutionExistsWithClient;
        $this->bus = $bus;
    }

    public function __invoke(DebtRejection $debtRejection): void
    {
        $domiciliation = $this->getDomiciliation($debtRejection);
        $devolutionExists = $this->checkDevolutionExists($debtRejection);
        $devolutionExistsWithClient = $this->checkDevolutionExistsWithClient($debtRejection);

        $firstValidation = new DomiciliationCreatedWithExternalCustomerIdHandler($debtRejection, $domiciliation, $devolutionExistsWithClient, $this->bus);
        $secondValidation = new WithoutDomiciliationByOldFormatHandler($debtRejection, $domiciliation, $devolutionExistsWithClient, $this->bus);
        $thirdValidation = new PendingOfInsertDevolutionHandler($debtRejection, $domiciliation, $devolutionExists, $this->bus);

        $firstValidation->setNext($secondValidation);
        $secondValidation->setNext($thirdValidation);
        $firstValidation->handle();
    }

    private function getDomiciliation($debtRejection): Bancara
    {
        return $this->domiciliationFinder->__invoke(
            $debtRejection->refundId()->value(),
            $debtRejection->internalId()->value()
        );
    }

    private function checkDevolutionExists($debtRejection): int
    {
        return $this->devolutionExists->__invoke(
            $debtRejection->refundId()->value(),
            $debtRejection->internalId()->value()
        );
    }

    public function checkDevolutionExistsWithClient($debtRejection): int
    {
        return $this->devolutionExistsWithClient->__invoke(
            $debtRejection->internalId()->valueAsNumeric(),
            $debtRejection->creationDateTime()->value(),
            $debtRejection->paymentDate()->value()
        );
    }
}
