<?php

namespace payment\Dto;

/**
 * Class StartDto
 * @package app\core\components\Dto\Transaction
 */
class StartDto
{
    /**
     * @var int $orderId
     */
    protected $orderId;

    /**
     * @var int $userId
     */
    protected $userId;

    /**
     * @var float $amount
     */
    protected $amount;

    /**
     * @var string $ip
     */
    protected $clientIp;

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
    public function setOrderId(int $orderId): StartDto
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): StartDto
    {
        $this->userId = $userId;

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

    /**
     * @return string
     */
    public function getClientIp(): string
    {
        return $this->clientIp;
    }

    /**
     * @param string $clientIp
     * @return $this
     */
    public function setClientIp(string $clientIp): StartDto
    {
        $this->clientIp = $clientIp;

        return $this;
    }

}