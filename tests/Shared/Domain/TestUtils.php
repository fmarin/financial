<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Domain;

use Financial\Tests\Shared\Infrastructure\Mockery\FinancialMatcherIsSimilar;
use Financial\Tests\Shared\Infrastructure\PhpUnit\Constraint\FinancialConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar($expected, $actual): bool
    {
        $constraint = new FinancialConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar($expected, $actual): void
    {
        $constraint = new FinancialConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo($value, $delta = 0.0): FinancialMatcherIsSimilar
    {
        return new FinancialMatcherIsSimilar($value, $delta);
    }
}
