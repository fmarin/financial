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
}