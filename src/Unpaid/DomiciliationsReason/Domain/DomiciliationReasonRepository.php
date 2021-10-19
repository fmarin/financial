<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DomiciliationsReason\Domain;

interface DomiciliationReasonRepository
{
    public function search($params = []): ?BancaraMotiv;
}


