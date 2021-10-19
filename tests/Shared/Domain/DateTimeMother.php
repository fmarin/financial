<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Domain;

final class DateTimeMother
{
    public static function random(): string
    {
        return MotherCreator::random()->date('Y-m-d H:i:s');
    }

    public static function randomWithT(): string
    {
        $datetime = MotherCreator::random()->dateTime()->format('Y-m-d H:i:s');
        return str_replace(" ", "T", $datetime);
    }
}
