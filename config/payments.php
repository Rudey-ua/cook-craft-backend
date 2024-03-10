<?php

use App\Services\Payment\PayPalService;

return [
    'payment_methods' => [
        'paypal' => 'PayPal',
        'stripe' => 'Stripe'
    ],
    'payment_services' => [
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

    'paypal' => [
        'events' => [
            'created' => 'BILLING.SUBSCRIPTION.CREATED',
            'activated' => 'BILLING.SUBSCRIPTION.ACTIVATED',
            'cancelled' => 'BILLING.SUBSCRIPTION.CANCELLED',
            'suspended' => 'BILLING.SUBSCRIPTION.SUSPENDED',
            're-activated' => 'BILLING.SUBSCRIPTION.RE-ACTIVATED',
            'payment_completed' => 'PAYMENT.SALE.COMPLETED',
            'payment_failed' => 'BILLING.SUBSCRIPTION.PAYMENT.FAILED'
        ],
    ]
];
