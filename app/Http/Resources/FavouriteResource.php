<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new ShortUserResource(User::findOrFail($this->user_id)),
            'recipe' => new RecipeResource(Recipe::findOrFail($this->recipe_id))
        ];
    }
}
