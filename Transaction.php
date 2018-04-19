<?php

namespace payment;


interface Transaction
{
    public function setRef(string $ref): Transaction;

    public function getRef(): string;

    public function setPaymentUrl(string $url): Transaction;

    public function getPaymentUrl(): string;

    public function setRefundAmount(float $amount): Transaction;

    public function getRefundAmount(): float;
}