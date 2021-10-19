<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Domain;

final class IbanMother
{
    public static function random(): string
    {
        return MotherCreator::random()->iban('ES');
    }
}
