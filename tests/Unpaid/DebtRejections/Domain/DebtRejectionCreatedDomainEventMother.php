<?php

declare(strict_types=1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\DebtRejections\Domain\DebtRejectionCreatedDomainEvent;

final class DebtRejectionCreatedDomainEventMother
{
    public static function create(DebtRejection $debtRejection): DebtRejectionCreatedDomainEvent
    {
        return new DebtRejectionCreatedDomainEvent($debtRejection->id()->value(), $debtRejection);
    }
}
