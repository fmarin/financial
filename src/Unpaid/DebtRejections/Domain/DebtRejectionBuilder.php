<?php

declare(strict_types = 1);

namespace Financial\Unpaid\DebtRejections\Domain;

use Financial\Shared\Domain\ValueObject\Uuid;

final class DebtRejectionBuilder
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

    public function setId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setBankFileName(BankFileName $bankFileName): self
    {
        $this->bankFileName = $bankFileName;
        return $this;
    }

    public function setCreationDateTime(CreationDateTime $creationDateTime): self
    {
        $this->creationDateTime = $creationDateTime;
        return $this;
    }

    public function setRefundId(RefundId $refundId): self
    {
        $this->refundId = $refundId;
        return $this;
    }

    public function setInternalId(Rdsdb5ClientId $internalId): self
    {
        $this->internalId = $internalId;
        return $this;
    }

    public function setTransactionStatus(TransactionStatus $transactionStatus): self
    {
        $this->transactionStatus = $transactionStatus;
        return $this;
    }

    public function setStatusReasonCode(StatusReasonCode $statusReasonCode): self
    {
        $this->statusReasonCode = $statusReasonCode;
        return $this;
    }

    public function setDebtAmount(DebtAmount $debtAmount): self
    {
        $this->debtAmount = $debtAmount;
        return $this;
    }

    public function setPaymentDate(PaymentDate $paymentDate): self
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    public function setDebtorAccount(DebtorAccount $debtorAccount): self
    {
        $this->debtorAccount = $debtorAccount;
        return $this;
    }

    public function setCreditorAccount(DigiAccount $creditorAccount): self
    {
        $this->creditorAccount = $creditorAccount;
        return $this;
    }

    public function setDebtorName(DebtorName $debtorName): self
    {
        $this->debtorName = $debtorName;
        return $this;
    }

    public function setProcessStatus(ProcessStatus $processStatus): self
    {
        $this->processStatus = $processStatus;
        return $this;
    }

    // Builder
    public function build(): DebtRejection
    {
        return DebtRejection::create($this);
    }

    // Getters
    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBankFileName(): BankFileName
    {
        return $this->bankFileName;
    }

    public function getCreationDateTime(): CreationDateTime
    {
        return $this->creationDateTime;
    }

    public function getRefundId(): RefundId
    {
        return $this->refundId;
    }

    public function getInternalId(): Rdsdb5ClientId
    {
        return $this->internalId;
    }

    public function getTransactionStatus(): TransactionStatus
    {
        return $this->transactionStatus;
    }

    public function getStatusReasonCode(): StatusReasonCode
    {
        return $this->statusReasonCode;
    }

    public function getDebtAmount(): DebtAmount
    {
        return $this->debtAmount;
    }

    public function getPaymentDate(): PaymentDate
    {
        return $this->paymentDate;
    }

    public function getDebtorAccount(): DebtorAccount
    {
        return $this->debtorAccount;
    }

    public function getCreditorAccount(): DigiAccount
    {
        return $this->creditorAccount;
    }

    public function getDebtorName(): DebtorName
    {
        return $this->debtorName;
    }

    public function getProcessStatus(): ProcessStatus
    {
        return $this->processStatus;
    }
}