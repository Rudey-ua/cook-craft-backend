<?php

namespace App\Http\Resources;

use App\Traits\FIleTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StepResource extends JsonResource
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
            'description' => $this->description,
            'photos' => $this->getStepsRecipePhotos(json_decode($this->photos, true))
        ];
    }
}
