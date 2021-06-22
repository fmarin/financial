<?php

declare(strict_types = 1);

namespace Financial\Shared\Domain;

interface CoRHandlerInterface
{
    /** set the next handler: */
    public function setNext(CoRHandlerInterface $next);
    /** run this handler's code */
    public function handle();
    /** run the next handler  */
    public function next();
}