<?php

declare(strict_types = 1);

namespace Financial\Tests\Shared\Infrastructure;

use Financial\Shared\Domain\RandomNumberGenerator;

final class ConstantRandomNumberGenerator implements RandomNumberGenerator
{
    public function generate(): int
    {
        return 1;
    }
}
