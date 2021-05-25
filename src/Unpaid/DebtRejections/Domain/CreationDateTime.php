<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\StringValueObject;

final class CreationDateTime extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = str_replace("T", " ", $value);
        parent::__construct($value);
    }
}