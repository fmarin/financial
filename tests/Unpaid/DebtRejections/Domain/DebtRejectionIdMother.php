<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

use Financial\Tests\Shared\Domain\UuidMother;
use Financial\Shared\Domain\ValueObject\Uuid;

final class DebtRejectionIdMother
{
    public static function create(string $value): Uuid
    {
        return new Uuid($value);
    }

    public static function creator(): callable
    {
        return static function () {
            return self::random();
        };
    }

    public static function random(): Uuid
    {
        return self::create(UuidMother::random());
    }
}
