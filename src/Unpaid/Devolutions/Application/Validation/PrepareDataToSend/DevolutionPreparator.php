<?php

declare(strict_types = 1);

namespace Financial\Unpaid\Devolutions\Application\Validation\PrepareDataToSend;


use Financial\Unpaid\DebtRejections\Domain\DebtRejection;
use Financial\Unpaid\Domiciliations\Domain\Bancara;

final class DevolutionPreparator
{
    const DEVOLUTION_INITIAL_STATUS = 0;

    private DebtRejection $debtRejection;
    private Bancara $domiciliation;
    private int $insertType;

    public function __construct(DebtRejection $debtRejection, Bancara $domiciliation, int $insertType)
    {
        $this->debtRejection = $debtRejection;
        $this->domiciliation = $domiciliation;
        $this->insertType = $insertType;
    }

    public function __invoke(): array
    {
        return [
            'internalId' => $this->debtRejection->InternalId()->value(),
            'type' => $this->domiciliation->type()->value(),
            'creationDateTime' => $this->debtRejection->CreationDateTime()->value(),
            'bankId' => $this->domiciliation->bankId()->value(),
            'debtAmount' => $this->debtRejection->DebtAmount()->value(),
            'paymentDate' => $this->debtRejection->PaymentDate()->value(),
            'statusReasonCode' => $this->debtRejection->StatusReasonCode()->value(),
            'status' => self::DEVOLUTION_INITIAL_STATUS,
            'bankFileName' => $this->debtRejection->BankFileName()->value(),
            'localUserId' => 123456,
            'fileSource' => '/PATH/',
            'uniqueKey' => $this->debtRejection->refundId()->value() . $this->debtRejection->internalId()->value(),
            'debtorAccount' => $this->debtRejection->DebtorAccount()->value(),
            'creditorAccount' => $this->debtRejection->CreditorAccount()->value(),
            'suffix' => '',
            'rezInsert' => $this->insertType
        ];
    }
}