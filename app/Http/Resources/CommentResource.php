<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'title' => $this->title,
            'rate' => round($this->rate, 1),
            'recipe_id' => $this->recipe_id,
            'user_id' => new ShortUserResource(User::find($this->user_id)),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
