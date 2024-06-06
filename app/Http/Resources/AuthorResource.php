<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Traits\FIleTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    use FIleTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::withCount('subscribers', 'subscriptions')->find($this->id);

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'profile_image' => $this->getProfileImageUrl($this->profile_image),
            'userDetails' => new UserDetailsResource($this->userDetails),
            'role' =>  $this->roles()->first()->name,
            'recipes' => ShortRecipeResource::collection($this->recipes),
            'subscribers_count' => $user->subscribers_count,
            'subscriptions_count' => $user->subscriptions_count
        ];
    }
}
