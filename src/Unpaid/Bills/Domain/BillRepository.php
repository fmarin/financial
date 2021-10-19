<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Bills\Domain;

interface BillRepository
{
    public function saveBillAndBillLoad($params = []): void;

    public function execute($params = []): void;
}
