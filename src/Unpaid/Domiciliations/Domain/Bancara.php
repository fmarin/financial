<?php

declare(strict_types=1);

namespace Financial\Unpaid\Domiciliations\Domain;

final class Bancara
{
    private Id $id;
    private BankId $bankId;
    private BillId $billId;
    private Incasat $incasat;
    private Status $status;
    private Type $type;

    public function __construct(Id $id, BankId $bankId, BillId $billId, Incasat $incasat, Status $status, Type $type)
    {
        $this->id = $id;
        $this->bankId = $bankId;
        $this->billId = $billId;
        $this->incasat = $incasat;
        $this->status = $status;
        $this->type = $type;
    }

    public static function create(
        Id $id,
        BankId $bankId,
        BillId $billId,
        Incasat $incasat,
        Status $status,
        Type $type
    ): self
    {
        return new self($id, $bankId, $billId, $incasat, $status, $type);
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function bankId(): BankId
    {
        return $this->bankId;
    }

    public function billId(): BillId
    {
        return $this->billId;
    }

    public function incasat(): Incasat
    {
        return $this->incasat;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function type(): Type
    {
        return $this->type;
    }
}
