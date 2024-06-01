<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Traits\FIleTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'user' => new ShortUserResource(User::findOrFail($this->user_id)),
            'cooking_time' => $this->cooking_time,
            'difficulty_level' => $this->difficulty_level,
            'portions' => $this->portions,
            'average_rating' => $this->countAverageRatingForRecipe(),
            'is_approved' => !is_null($this->is_approved) && $this->is_approved,
            'is_published' => !is_null($this->is_published) && $this->is_published,
            'cover_photo' => $this->getRecipeCoverPhoto($this->cover_photo),
            'ingredients' => IngredientResource::collection($this->ingredients),
            'steps' => StepResource::collection($this->steps),
            'tags' => TagResource::collection($this->tags)
        ];
    }
}
