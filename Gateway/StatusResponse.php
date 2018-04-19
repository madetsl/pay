<?php

namespace payment\Gateway;

interface StatusResponse extends Response
{
    public function isPaid(): bool;

    public function isCanceled(): bool;

    public function canReverse(): bool;

    public function canRefund(): bool;
}