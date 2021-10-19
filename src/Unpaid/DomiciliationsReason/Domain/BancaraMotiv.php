<?php

declare(strict_types=1);

namespace Financial\Unpaid\DomiciliationsReason\Domain;

final class BancaraMotiv
{
    private Id $id;
    private Code $code;
    private Reason $reason;

    public function __construct(Id $id, Code $code, Reason $reason)
    {
        $this->id = $id;
        $this->code = $code;
        $this->reason = $reason;
    }

    public static function create(Id $id, Code $code, Reason $reason): self
    {
        return new self($id, $code, $reason);
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function reason(): Reason
    {
        return $this->reason;
    }
}
