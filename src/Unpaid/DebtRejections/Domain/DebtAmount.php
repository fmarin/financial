<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\StringValueObject;

final class DebtAmount extends StringValueObject
{
    public function getValueInNegative(): string
    {
        return '-' . $this->value();
    }
}