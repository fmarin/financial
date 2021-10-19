<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Application\Create;

use Financial\Shared\Domain\Bus\Event\EventBus;
use Financial\Unpaid\Bills\Domain\BillRepository;
use Financial\Unpaid\DomiciliationsReason\Application\Find\DomiciliationReasonFinder;

final class BillCreator
{
    private BillRepository $repository;
    private DomiciliationReasonFinder $reasonFinder;
    private EventBus $bus;

    public function __construct(BillRepository $repository, DomiciliationReasonFinder $reasonFinder, EventBus $bus)
    {
        $this->repository = $repository;
        $this->reasonFinder = $reasonFinder;
        $this->bus = $bus;
    }

    public function __invoke(&$billData)
    {
        dump('SAVE BILL AND BILL LOAD');

        $domiciliationReason = $this->reasonFinder->__invoke($billData['statusReasonCode']);

        $billData['reason'] = $domiciliationReason->reason()->value();

        $this->repository->saveBillAndBillLoad($billData);
    }
}