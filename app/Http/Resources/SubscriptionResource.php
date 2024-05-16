<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'is_active' => (bool)$this->is_active,
            'is_canceled' =>(bool)$this->is_canceled,
            'start_date' => $this->start_date,
            'expired_date' => $this->expired_date,
            'plan' => $this->plan,
            'provider_name' => $this->provider_name,
            'renewal_count' => $this->renewal_count,
            'provider_subscription_id' => $this->provider_subscription_id,
            'cancel_reason' => $this->cancel_reason,
        ];
    }
}
