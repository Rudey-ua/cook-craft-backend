<?php

namespace App\Http\Resources;

use App\Traits\FIleTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ShortUserResource extends JsonResource
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
            'profile_image' => $this->getProfileImageUrl($this->profile_image),
        ];
    }
}
