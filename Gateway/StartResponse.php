<?php

namespace payment\Gateway;


interface StartResponse extends Response
{
    public function isStarted(): bool;

    public function getRef(): string;

    public function getPaymentUrl(): string;
}