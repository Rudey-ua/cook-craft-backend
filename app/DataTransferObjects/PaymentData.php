<?php

namespace App\DataTransferObjects;

class PaymentData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $modelId,
        public readonly string $modelType,
        public readonly string $paymentMethod,
        public readonly string $transactionData,
        public readonly string $paymentDate,
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $status
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'model_id' => $this->modelId,
            'model_type' => $this->modelType,
            'payment_method' => $this->paymentMethod,
            'transaction_data' => $this->transactionData,
            'payment_date' => $this->paymentDate,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status
        ];
    }
}
