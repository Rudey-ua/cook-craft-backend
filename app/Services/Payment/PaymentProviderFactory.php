<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentProviderInterface;
use Illuminate\Support\Facades\App;

class PaymentProviderFactory
{
    public static function create(string $provider): PaymentProviderInterface
    {
        switch ($provider) {
            case config('payments.payment_methods.paypal'):
                return App::make(PayPalService::class);
            default:
                throw new Exception('Invalid payment provider');
        }
    }
}
