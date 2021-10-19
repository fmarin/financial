<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure\Mockery;

use Financial\Tests\Shared\Infrastructure\PhpUnit\Constraint\FinancialConstraintIsSimilar;
use Mockery\Matcher\MatcherAbstract;

final class FinancialMatcherIsSimilar extends MatcherAbstract
{
    private FinancialConstraintIsSimilar $constraint;

    public function __construct($value, $delta = 0.0)
    {
        parent::__construct($value);

        $this->constraint = new FinancialConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}
