<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\SubscriptionRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(protected SubscriptionRepository $subscriptionRepository)
    {
    }

    public function getProfileData()
    {
        return $this->respondWithSuccess(new UserResource(Auth::user()));
    }
}
