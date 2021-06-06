<?php

declare(strict_types = 1);

namespace Financial\Shared\Domain;

use DateTimeInterface;

final class Utils
{
    public static function endsWith(string $needle, string $haystack): bool
    {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }
}
