<?php

namespace App\Http\Resources;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::withCount('subscribers')->find($this->author_id);

        return [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'profile_image' => $user->profile_image,
            'subscribers_count' => $user->subscribers_count
        ];
    }
}
