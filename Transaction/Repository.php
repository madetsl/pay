<?php

namespace payment\Transaction;

use payment\Dto\StartDto;
use payment\Transaction;

interface Repository
{
    public function create(StartDto $data): Transaction;

    public function activate(Transaction $transaction): bool;

    public function pay(Transaction $transaction): bool;

    public function cancel(Transaction $transaction): bool;

    public function finish(Transaction $transaction): bool;

    /**
     * @param int $orderId
     * @return Transaction[]
     */
    public function getActiveTransactionsByOrderId(int $orderId): array;

}