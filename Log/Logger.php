<?php

namespace payment\Log;


use payment\Transaction;

interface Logger
{
    public function log(Transaction $transaction, Log $log);
}