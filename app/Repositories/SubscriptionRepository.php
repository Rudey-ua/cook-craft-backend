<?php

namespace App\Repositories;

use App\DataTransferObjects\SubscriptionData;
use App\Models\Plan;
use App\Models\Subscription;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubscriptionRepository
{
    public function __construct(
        private readonly Subscription $subscriptionModel,
        private readonly Plan $planModel,
    ) {}

    public function create(SubscriptionData $subscriptionData): Subscription
    {
        try {
            $subscription = $this->subscriptionModel->create($subscriptionData->toArray());
        } catch (Throwable $e) {
            Log::error('Error while creating subscription: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $subscription;
    }

    public function getActiveSubscription(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('is_active', true)
            ->where('expired_date', '>', now())
            ->first();
    }

    public function getUserActiveSubscriptionByProvider(string $provider, int $userId): ?Subscription
    {
        $provider = strtolower($provider);

        return Subscription::where('user_id', $userId)
            ->where('provider_name', config("payments.payment_methods.{$provider}"))
            ->where('is_active', true)
            ->where('expired_date', '>', now())
            ->first();
    }

    public function getPlanById(int $id): Plan
    {
        return $this->planModel->findOrFail($id);
    }
}
