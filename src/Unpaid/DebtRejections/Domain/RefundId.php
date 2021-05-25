<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\StringValueObject;

final class RefundId extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = substr($value, 0, 6);
        parent::__construct($value);
    }
}