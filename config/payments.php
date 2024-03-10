<?php

use App\Services\Payment\PayPalService;

return [
    'payment_methods' => [
        'paypal' => 'PayPal',
        'stripe' => 'Stripe'
    ],
    'payment_instance' => [
        'paypal' => PayPalService::class,
    ],
    'currencies' => [
        'euro' => 'EUR'
    ],
    'transaction_statuses' => [
        'pending' => 'PENDING',
        'completed' => 'COMPLETED',
        'failed' => 'FAILED',
    ],
];
