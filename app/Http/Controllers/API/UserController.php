<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\FollowersResource;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\UserResource;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected UserService $userService,
        protected UserRepository $userRepository
    )
    {}

    public function getProfileData()
    {
        return $this->respondWithSuccess(new UserResource(Auth::user()));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        try {
            $userData = $this->userRepository->update($validated, Auth::user());
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new UserResource($userData);
    }

    public function getUserRecipes() : JsonResource
    {
        return RecipeResource::collection(Auth::user()->recipes);
    }

    public function getAuthorProfile(int $id)
    {
        $author = $this->userRepository->getUserById($id);

        return new AuthorResource($author);
    }

    public function getUserSubscriptions()
    {
        return FollowersResource::collection(Auth::user()->subscriptions);
    }
}
