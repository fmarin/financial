<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\StringValueObject;

final class Rdsdb5ClientId extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = substr($value, -10);
        parent::__construct($value);
    }

    public function isNumeric(): int
    {
        return preg_match("/^\d+$/", $this->value);
    }

    public function valueAsNumeric(): int
    {
        return (int) $this->value;
    }
}