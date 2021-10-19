<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Infrastructure\Persistence\Doctrine;

use Financial\Shared\Domain\ValueObject\Uuid;
use Financial\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class DebtRejectionIdType extends UuidType
{
    public static function customTypeName(): string
    {
        return 'debt_rejection_id';
    }

    protected function typeClassName(): string
    {
        return Uuid::class;
    }
}
