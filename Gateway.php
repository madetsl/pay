<?php

namespace payment;

use payment\Gateway\CommitResponse;
use payment\Gateway\RollbackResponse;
use payment\Gateway\StartResponse;
use payment\Gateway\StatusResponse;

interface Gateway
{
    public function start(Transaction $transaction): StartResponse;

    public function getStatus(Transaction $transaction): StatusResponse;

    public function reverse(Transaction $transaction): RollbackResponse;

    public function refund(Transaction $transaction): RollbackResponse;

    public function commit(Transaction $transaction): CommitResponse;
}