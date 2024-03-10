<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSubscriptionRequest;
use App\Repositories\SubscriptionRepository;
use App\Services\Payment\PaymentProviderFactory;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    use ApiResponseHelpers;
    public function __construct(protected SubscriptionRepository $subscriptionRepository)
    {
    }

    public function createSubscription(CreateSubscriptionRequest $request) : JsonResponse
    {
        $data = $this->extractRequestData($request);

        try {
            if (!is_null($this->subscriptionRepository->getActiveSubscription(Auth::id()))) {
                return throw new \Exception(__("You already have an active subscription!"));
            }
            $paymentProvider = PaymentProviderFactory::create($data['paymentMethod']);
            $subscriptionData = $paymentProvider->createSubscription($data['planId']);

        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess([
            'message' => __('Subscription created successfully'),
            'data' => $subscriptionData
        ]);
    }

    private function extractRequestData($request)
    {
        return [
            'paymentMethod' => $request->validated()['paymentMethod'],
            'planId' => $request->validated()['planId'] ?? null,
        ];
    }
}
