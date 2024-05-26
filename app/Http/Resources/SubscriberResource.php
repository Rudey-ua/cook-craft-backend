<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
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
            'author_id' => new ShortUserResource(User::findOrFail($this->author_id)),
            'user_id' => new ShortUserResource(User::findOrFail($this->user_id)),
            'subscribers_count' => User::findOrFail($this->author_id)->subscribersCount(),
        ];
    }
}
