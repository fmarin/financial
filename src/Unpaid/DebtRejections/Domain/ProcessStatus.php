<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\IntValueObject;

final class ProcessStatus extends IntValueObject
{
    const DEVOLUTION_CREATED_BEFORE = "-1";
    const DEVOLUTION_CREATED_OK = "1";
    const DEVOLUTION_CREATED_WITH_EXTERNAL_CUSTOMER_ID = "2";
    const DEVOLUTION_CREATED_WITHOUT_DOMICILIATION_BY_OLD_FORMAT = "3";
}
