<?php

namespace App\Http\Resources;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FollowersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::withCount('subscribers')->find($this->author_id);

        return [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'profile_image' => $this->getProfileImageUrl($user->profile_image),
            'subscribers_count' => $user->subscribers_count
        ];
    }
    public function getProfileImageUrl($filename): ?string
    {
        if (!$filename) {
            return null;
        }
        return Storage::disk('public')->url('profile_images/' . $filename);
    }
}
