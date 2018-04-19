<?php

namespace payment;


use Psr\Log\LoggerInterface;

class Process
{
    /**
     * @var Gateway
     */
    protected $gateway;

    /**
     * @var Transaction\Repository
     */
    protected $transactionRepository;

    /**
     * @var Log\Logger
     */
    protected $transactionLogger;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        Gateway $gateway,
        Transaction\Repository $transactionRepository,
        Log\Logger $transactionLogger,
        LoggerInterface $logger
    )
    {
        $this->gateway = $gateway;
        $this->transactionRepository = $transactionRepository;
        $this->transactionLogger = $transactionLogger;
        $this->logger = $logger;
    }

    public function start(Dto\StartDto $data): Transaction
    {
        $transaction = $this->transactionRepository->create($data);

        $response = $this->gateway->start($transaction);

        if ($response->isSuccess() && $response->isStarted()) {
            $transaction
                ->setRef($response->getRef())
                ->setPaymentUrl($response->getPaymentUrl());

            $this->transactionRepository->activate($transaction);
        } else {
            $this->transactionRepository->cancel($transaction);
        }

        $this->logResponse($transaction, $response);

        return $transaction;
    }

    public function commit(Dto\CommitDto $data): Transaction
    {
        $transactions = $this->checkStatusTransactions(
            $data->getOrderId(),
            function (Transaction $transaction, Gateway\StatusResponse $status) {
                if ($status->isPaid()) {
                    $response = $this->gateway->commit($transaction);

                    if ($response->isSuccess()) {
                        $this->transactionRepository->finish($transaction);
                    }

                    $this->logResponse($transaction, $response);
                }
            }
        );

        return $transactions[0];
    }

    public function rollback(Dto\RollbackDto $data): Transaction
    {
        $transactions = $this->checkStatusTransactions(
            $data->getOrderId(),
            function (Transaction $transaction, Gateway\StatusResponse $status) use ($data) {
                if ($status->isPaid()) {
                    $transaction->setRefundAmount($data->getAmount());

                    if ($status->canReverse()) {
                        $response = $this->gateway->reverse($transaction);
                    } elseif ($status->canRefund()) {
                        $response = $this->gateway->refund($transaction);
                    } else {
                        // @todo WrongState
                    }

                    if ($response->isSuccess()) {
                        $this->transactionRepository->finish($transaction);
                    }

                    $this->logResponse($transaction, $response);
                }
            }
        );

        return $transactions[0];
    }

    protected function checkStatusTransactions(int $orderId, callable $successHandler): array
    {
        $res = [];

        foreach ($this->transactionRepository->getActiveTransactionsByOrderId($orderId) as $transaction) {
            $response = $this->gateway->getStatus($transaction);

            if ($response->isSuccess()) {
                if ($response->isPaid()) {
                    $this->transactionRepository->pay($transaction);
                } elseif ($response->isCanceled()) {
                    $this->transactionRepository->cancel($transaction);
                }

                $res[] = call_user_func($successHandler, $transaction, $response);
            }

            $this->logResponse($transaction, $response);
        }

        return $res;
    }

    protected function logResponse(Transaction $transaction, Gateway\Response $response)
    {
        if ($response instanceof Log\Logable) {
            $this->transactionLogger->log($transaction, $response->toLog());
        }
    }
}