<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $subscription = $this->subscription;

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'profile_image' => $this->profile_image,
            'is_active' => $this->is_active == 1,
            'userDetails' => new UserDetailsResource($this->userDetails),
            'role' =>  $this->roles()->get()->toArray(),
            'is_active_subscription' => $subscription && (bool)$subscription->is_active,
            'is_canceled_subscription' => $subscription && (bool)$subscription->is_canceled
        ];
    }
}
