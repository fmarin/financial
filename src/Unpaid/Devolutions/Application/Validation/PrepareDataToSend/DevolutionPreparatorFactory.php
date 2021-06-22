<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\PrepareDataToSend;

use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DevolutionPreparatorFactory
{
    public static function create(DebtRejection $debtRejection, Bancara $domiciliation, int $insertType): DevolutionPreparator
    {
        return new DevolutionPreparator($debtRejection, $domiciliation, $insertType);
    }
}