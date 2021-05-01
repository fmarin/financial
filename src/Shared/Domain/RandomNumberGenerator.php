<?php

declare(strict_types = 1);

namespace Financial\Shared\Domain;

interface RandomNumberGenerator
{
    public function generate(): int;
}
