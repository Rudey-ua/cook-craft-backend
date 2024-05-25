<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use App\Services\UserService;
use F9Web\ApiResponseHelpers;
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
}
