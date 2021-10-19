<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\StringValueObject;
use DateTime;

final class CreationDateTime extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = str_replace("T", " ", $value);
        parent::__construct($value);
    }

    public function generateNumberToBill(): string
    {
        $date = new DateTime($this->value());
        return $date->format('dm');
    }

    public function getDateToBill(): string
    {
        $date = new DateTime($this->value());
        return $date->format('Y-m-d');
    }
}