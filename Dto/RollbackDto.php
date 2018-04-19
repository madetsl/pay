<?php

namespace payment\Dto;

/**
 * Class RollbackDto
 * @package app\core\components\Dto\Transaction
 */
class RollbackDto
{
    /**
     * @var int
     */
    protected $orderId;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return $this
     */
    public function setOrderId(int $orderId): RollbackDto
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return $this
     */
    public function setAmount(float $amount): StartDto
    {
        $this->amount = $amount;

        return $this;
    }
}