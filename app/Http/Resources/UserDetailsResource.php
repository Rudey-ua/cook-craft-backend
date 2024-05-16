<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'language' => $this->language,
            'time_zone' => $this->time_zone
        ];
    }
}
