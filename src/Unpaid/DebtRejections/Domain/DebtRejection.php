<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\Aggregate\AggregateRoot;
use Financial\Shared\Domain\ValueObject\Uuid;

final class DebtRejection extends AggregateRoot
{
    private Uuid $id;
    private BankFileName $bankFileName;
    private CreationDateTime $creationDateTime;
    private RefundId $refundId;
    private Rdsdb5ClientId $internalId;
    private TransactionStatus $transactionStatus;
    private StatusReasonCode $statusReasonCode;
    private DebtAmount $debtAmount;
    private PaymentDate $paymentDate;
    private DebtorAccount $debtorAccount;
    private DigiAccount $creditorAccount;
    private DebtorName $debtorName;
    private ProcessStatus $processStatus;

    public function __construct(DebtRejectionBuilder $debtRejectionBuilder)
    {
        $this->id = $debtRejectionBuilder->getId();
        $this->bankFileName = $debtRejectionBuilder->getBankFileName();
        $this->creationDateTime = $debtRejectionBuilder->getCreationDateTime();
        $this->refundId = $debtRejectionBuilder->getRefundId();
        $this->internalId = $debtRejectionBuilder->getInternalId();
        $this->transactionStatus = $debtRejectionBuilder->getTransactionStatus();
        $this->statusReasonCode = $debtRejectionBuilder->getStatusReasonCode();
        $this->debtAmount = $debtRejectionBuilder->getDebtAmount();
        $this->paymentDate = $debtRejectionBuilder->getPaymentDate();
        $this->debtorAccount = $debtRejectionBuilder->getDebtorAccount();
        $this->creditorAccount = $debtRejectionBuilder->getCreditorAccount();
        $this->debtorName = $debtRejectionBuilder->getDebtorName();
        $this->processStatus = $debtRejectionBuilder->getProcessStatus();
    }

    public static function create(DebtRejectionBuilder $debtRejectionBuilder): self
    {
        $debtRejection = new self($debtRejectionBuilder);

        $debtRejection->record(
            new DebtRejectionCreatedDomainEvent(
                $debtRejectionBuilder->getId()->value(),
                $debtRejection
            )
        );

        return $debtRejection;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function bankFileName(): BankFileName
    {
        return $this->bankFileName;
    }

    public function creationDateTime(): CreationDateTime
    {
        return $this->creationDateTime;
    }

    public function refundId(): RefundId
    {
        return $this->refundId;
    }

    public function internalId(): Rdsdb5ClientId
    {
        return $this->internalId;
    }

    public function transactionStatus(): TransactionStatus
    {
        return $this->transactionStatus;
    }

    public function statusReasonCode(): StatusReasonCode
    {
        return $this->statusReasonCode;
    }

    public function debtAmount(): DebtAmount
    {
        return $this->debtAmount;
    }

    public function paymentDate(): PaymentDate
    {
        return $this->paymentDate;
    }

    public function debtorAccount(): DebtorAccount
    {
        return $this->debtorAccount;
    }

    public function creditorAccount(): DigiAccount
    {
        return $this->creditorAccount;
    }

    public function debtorName(): DebtorName
    {
        return $this->debtorName;
    }

    public function processStatus(): ProcessStatus
    {
        return $this->processStatus;
    }
}
