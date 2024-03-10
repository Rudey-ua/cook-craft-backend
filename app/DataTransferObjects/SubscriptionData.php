<?php

namespace App\DataTransferObjects;

class SubscriptionData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $planId,
        public readonly string $type,
        public readonly bool $isActive,
        public readonly bool $isCanceled,
        public readonly string $startDate,
        public readonly string $expiredDate,
        public readonly ?string $providerName,
        public readonly ?string $providerSubscriptionId,
        public readonly int $renewalCount
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'plan_id' => $this->planId,
            'type' => $this->type,
            'is_active' => $this->isActive,
            'is_canceled' => $this->isCanceled,
            'start_date' => $this->startDate,
            'expired_date' => $this->expiredDate,
            'provider_name' => $this->providerName,
            'provider_subscription_id' => $this->providerSubscriptionId,
            'renewal_count' => $this->renewalCount
        ];
    }
}
