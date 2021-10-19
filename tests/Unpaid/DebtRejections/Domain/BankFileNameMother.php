<?php

declare(strict_types = 1);

namespace Financial\Tests\Unpaid\DebtRejections\Domain;

final class BankFileNameMother
{
    const TEST_FILE_NAME = 'DDddmmyy.000.xml';

    public static function fileNameForTest(): string
    {
        return self::TEST_FILE_NAME;
    }
}
