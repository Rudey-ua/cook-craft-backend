<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\SubscriptionRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(protected SubscriptionRepository $subscriptionRepository)
    {
    }

    public function index()
    {
        $subscription = $this->subscriptionRepository->getActiveSubscription(Auth::id());

        return $this->respondWithSuccess([
            'message' => 'Data successfully retrieved!',
            'data' => $subscription
        ]);
    }
}
