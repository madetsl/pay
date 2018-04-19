<?php

namespace payment\Dto;

/**
 * Class CommitDto
 * @package app\core\components\Dto\Transaction
 */
class CommitDto
{
    /**
     * @var int $orderId
     */
    protected $orderId;

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
    public function setOrderId(int $orderId): CommitDto
    {
        $this->orderId = $orderId;

        return $this;
    }
}