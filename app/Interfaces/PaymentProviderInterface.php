<?php

namespace App\Interfaces;

use App\Models\Subscription;
use Illuminate\Http\Request;

interface PaymentProviderInterface
{
    public function createSubscription(int $planId) : array;
    public function scheduleCancelSubscription(string $reason): void;
    public function performCancelSubscription(Subscription $subscription);
    public function getSubscriptionData(string $subscriptionId);
    public function handleWebhook(Request $request);
}
