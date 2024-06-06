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
        $author = User::withCount('subscribers')->findOrFail($this->author_id);
        $subscriber = User::findOrFail($this->user_id);

        return [
            'id' => $this->id,
            'author' => new ShortUserResource($author),
            'subscriber' => new ShortUserResource($subscriber),
            'subscribers_count' => $author->subscribers_count,
        ];
    }
}
