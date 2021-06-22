<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Domiciliations\Domain;

use Financial\Shared\Domain\ValueObject\IntValueObject;

final class BillId extends IntValueObject
{
    public function isEmpty(): bool
    {
        return empty($this->value);
    }
}