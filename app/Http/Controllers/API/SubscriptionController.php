<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancelSubscriptionRequest;
use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Repositories\SubscriptionRepository;
use App\Services\Payment\PaymentProviderFactory;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
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

    public function cancelSubscription(CancelSubscriptionRequest $request): JsonResponse
    {
        $data = $this->extractRequestData($request);

        if (is_null($subscription = $this->subscriptionRepository->getActiveSubscription(Auth::id()))) {
            return $this->respondNotFound(__("You don't have an active subscription!"));
        }
        if ($this->subscriptionRepository->checkIfSubscriptionCanceled($subscription)) {
            return $this->respondError(__("Your subscription already has been canceled!"));
        }
        try {
            $paymentProvider = PaymentProviderFactory::create($data['paymentMethod']);
            $paymentProvider->cancelSubscription($subscription, $data['reason']);
        } catch (\Exception $e) {
            Log::error('Subscription error: ' . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return $this->respondWithSuccess([
            'message' => __('Subscription successfully canceled!'),
        ]);
    }

    public function getUserSubscriptionInfo()
    {
        if (is_null(Auth::user()->subscription)) {
            return $this->respondError(__("You don't have an active subscription!"));
        }

        return $this->respondWithSuccess([
            'message' => 'Subscription data successfully retrieved!',
            'data' => new SubscriptionResource(Auth::user()->subscription)
        ]);
    }

    private function extractRequestData($request)
    {
        return [
            'paymentMethod' => $request->validated()['paymentMethod'],
            'planId' => $request->validated()['planId'] ?? null,
            'reason' => $request->validated()['reason'] ?? null
        ];
    }
}
