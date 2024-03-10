<?php

namespace App\Interfaces;

use App\Models\Subscription;
use Illuminate\Http\Request;

interface PaymentProviderInterface
{
    public function createSubscription(int $planId);
    public function cancelSubscription(Subscription $subscription);
    public function getSubscriptionData(string $subscriptionId);
    public function handleWebhook(Request $request);
}
