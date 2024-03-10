<?php

namespace App\Repositories;

use App\DataTransferObjects\PaymentData;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentRepository
{
    public function __construct(private readonly Payment $model) {}

    public function create(PaymentData $paymentData): string|Payment
    {
        try {
            $payment = $this->model->create($paymentData->toArray());
        } catch (Throwable $e) {
            Log::error('Error while creating payment record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $payment;
    }
}
