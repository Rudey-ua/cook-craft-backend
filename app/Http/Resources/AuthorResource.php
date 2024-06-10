<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use App\Models\Subscriber;
use App\Models\User;
use App\Traits\FIleTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $user = User::withCount('subscribers', 'subscriptions')->find($this->id);
        $isSubscribed = Subscriber::where('user_id', Auth::id())->where('author_id', $user->id)->exists();

        $recipes = Recipe::where('user_id', $this->id)
            ->where('is_published', true)
            ->get();

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'profile_image' => $this->getProfileImageUrl($this->profile_image),
            'userDetails' => new UserDetailsResource($this->userDetails),
            'role' =>  $this->roles()->first()->name,
            'recipes' => ShortRecipeResource::collection($recipes),
            'subscribers_count' => $user->subscribers_count,
            'subscriptions_count' => $user->subscriptions_count,
            'is_authenticated_user_subscribed' => $isSubscribed,
        ];
    }
}
