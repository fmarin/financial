<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Tests\Shared\Domain\MotherCreator;

final class DebtorNameMother
{
    public static function random(): string
    {
        return MotherCreator::random()->name();
    }
}
