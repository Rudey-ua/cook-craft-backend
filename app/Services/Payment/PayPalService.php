<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentProviderInterface;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PayPalService implements PaymentProviderInterface
{

    public function createSubscription(int $planId): array
    {
        // TODO: Implement createSubscription() method.
    }

    public function scheduleCancelSubscription(string $reason): void
    {
        // TODO: Implement scheduleCancelSubscription() method.
    }

    public function performCancelSubscription(Subscription $subscription)
    {
        // TODO: Implement performCancelSubscription() method.
    }

    public function getSubscriptionData(string $subscriptionId)
    {
        // TODO: Implement getSubscriptionData() method.
    }

    public function handleWebhook(Request $request)
    {
        // TODO: Implement handleWebhook() method.
    }
}
