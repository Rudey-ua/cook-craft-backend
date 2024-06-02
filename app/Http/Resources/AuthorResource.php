<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'profile_image' => $this->getProfileImageUrl($this->profile_image),
            'userDetails' => new UserDetailsResource($this->userDetails),
            'role' =>  $this->roles()->first()->name,
            'recipes' => RecipeResource::collection($this->recipes),
            'subscribers_count' => $this->subscribersCount(),
            'subscriptions_count' => $this->subscriptionsCount($this->id)
        ];
    }
}