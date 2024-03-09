<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function getActiveSubscription(int $userId): ?Subscription
    {
        return Subscription::where('user_id', $userId)
            ->where('is_active', true)
            ->where('expired_date', '>', now())
            ->first();
    }
}
