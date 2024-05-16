<?php

namespace App\Repositories;

use App\DataTransferObjects\SubscriptionData;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\Payment\PayPalService;
use Exception;
use Illuminate\Support\Carbon;
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

    public function checkIfSubscriptionCanceled(Subscription $subscription): bool
    {
        return $subscription->is_canceled;
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

    public function renewSubscription(Subscription $subscription): void
    {
        $startDate = $subscription->end_date;
        $endDate = (new Carbon($startDate))->addMonth();

        $subscription->update([
            'start_date' => $startDate,
            'expired_date' => $endDate,
            'renewal_count' => $subscription->renewal_count + 1,
        ]);

        $logData = [
            'Payment Provider' => $subscription->provider_name,
            'Provider Subscription ID' => $subscription->provider_subscription_id,
            'User Type' => 'STUDENT',
            'User ID' => $subscription->user_id,
            'Renewal Count' => $subscription->renewal_count
        ];

        Log::channel('subscription')->info("Subscription successfully renewed. Details: " . json_encode($logData));
    }

    public function cancelPayPalSubscription($paypalSubscriptionId): void
    {
        $subscription = Subscription::where('provider_subscription_id', $paypalSubscriptionId)
            ->where('is_active', true)
            ->where('expired_date', '>', now())
            ->firstOrFail();

        $subscriptionData = app(PayPalService::class)->getSubscriptionData($subscription->provider_subscription_id);

        $subscription->update(['is_active' => false]);
        $subscription->update(['is_canceled' => true]);
        $subscription->update(['updated_at' => now()]);
        $subscription->update(['cancel_reason' => $subscriptionData['status_change_note']]);
    }
}
