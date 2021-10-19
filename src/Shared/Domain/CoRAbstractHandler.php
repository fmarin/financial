<?php

declare(strict_types = 1);

namespace Financial\Shared\Domain;

abstract class CoRAbstractHandler implements CoRHandlerInterface
{
    protected CoRHandlerInterface $next;

    public function setNext(CoRHandlerInterface $next)
    {
        $this->next = $next;
    }

    public function next()
    {
        if ($this->next) {
            return $this->next->handle();
        }
    }
}