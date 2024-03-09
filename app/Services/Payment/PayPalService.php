<?php

namespace App\Services\Payment;

use App\Interfaces\PaymentProviderInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayPalService implements PaymentProviderInterface
{
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected UserRepository $userRepository
    )
    {
        $this->PAYPAL_CLIENT_ID = config('services.paypal.client_id');
        $this->PAYPAL_SECRET = config('services.paypal.secret');
        $this->PAYPAL_BASE_URL = config('services.paypal.base_url');
    }
    private function getAccessToken() : string
    {
        $response = Http::withBasicAuth($this->PAYPAL_CLIENT_ID, $this->PAYPAL_SECRET)
            ->asForm()
            ->post("$this->PAYPAL_BASE_URL/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to get PayPal access token");
        }
        return $response->json()['access_token'];
    }

    public function createProduct(): JsonResponse
    {
        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/catalogs/products", [
                'name' => 'Zemfyra Monthly Subscriptions',
                'description' => 'Flexible one-month subscription',
                'type' => 'DIGITAL',
                'category' => 'SOFTWARE',
                'image_url' => config('services.paypal.settings.image_url'),
                'home_url' => config('services.paypal.settings.home_url')
            ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to create product: " . $response->body());
        }
        return response()->json($response->json());
    }

    public function createSubscriptionPlan($planId): JsonResponse
    {
        $plan = Plan::findOrFail($planId);

        $product = $this->createProduct()->getData(true);

        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/billing/plans", [
                'product_id' => $product['id'],
                'name' => $plan->name,
                'description' => $plan->type,
                'status' => 'ACTIVE',
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => 'MONTH',
                            'interval_count' => 1
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $this->getSubscriptionPrice($plan, config('payments.payment_methods.paypal')),
                                'currency_code' => 'EUR'
                            ]
                        ]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => [
                        'value' => 0,
                        'currency_code' => 'EUR'
                    ],
                    'setup_fee_failure_action' => 'CONTINUE'
                ]
            ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to create subscription plan: " . $response->body());
        }
        return response()->json($response->json());
    }

    public function createSubscription($planId): array
    {
        $payPalPlan = $this->createSubscriptionPlan($planId)->getData(true);

        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->post("$this->PAYPAL_BASE_URL/v1/billing/subscriptions", [
                'plan_id' => $payPalPlan['id'],
                'custom_id' => json_encode(
                    [
                        'plan_id' => $planId,
                        'user_id' => Auth::user()->id
                    ], JSON_THROW_ON_ERROR
                ),
                'application_context' => [
                    'brand_name' => 'Zemfyra',
                    'locale' => 'en-US',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'SUBSCRIBE_NOW',
                    'return_url' => config('services.paypal.redirect_url.return_url'),
                    'cancel_url' => config('services.paypal.redirect_url.cancel_url')
                ]
            ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to create subscription: " . $response->body());
        }
        $approvalUrl = collect($response['links'])->where('rel', 'approve')->first()['href'];

        return [
            'provider_name' => config('payments.payment_methods.paypal'),
            'provider_subscription_id' => $response['id'],
            'approval_url' => $approvalUrl,
        ];
    }

    public function scheduleCancelSubscription(string $reason): void
    {

    }

    public function performCancelSubscription(Subscription $subscription)
    {

    }

    public function getSubscriptionData($subscriptionId) : array
    {
        $response = Http::withToken($this->getAccessToken())
            ->asJson()
            ->get("$this->PAYPAL_BASE_URL/v1/billing/subscriptions/$subscriptionId");

        if (!$response->successful()) {
            Log::channel('subscription')->error('Failed to get subscription data:' . $response->body());
            throw new \Exception("Failed to get subscription data: " . $response->body());
        }
        return $response->json();
    }

    public function activateSubscription(Request $request): void
    {
        $subscriptionId = $request->input('subscription_id') ?? $request->input('resource.id');
        $subscriptionData = $this->getSubscriptionData($subscriptionId);

        DB::transaction(function () use ($subscriptionData) {

            $customData = json_decode($subscriptionData['custom_id'], true);
            $plan = $this->subscriptionRepository->getPlanById($customData['plan_id']);
            $user = $this->userRepository->getUserById($customData['user_id']);
            $dates = $this->getSubscriptionDates($subscriptionData['start_time']);

            if (is_null($this->subscriptionRepository->getUserActiveSubscriptionByProvider(config('payments.payment_methods.paypal'), $user->id))) {

                $subscription = $this->subscriptionRepository->create(
                    new SubscriptionData(
                        userId: $user->id,
                        planId: $plan->id,
                        type: config('subscription.types.monthly'),
                        isActive: $subscriptionData['status'] === 'ACTIVE',
                        isCanceled: false,
                        isPaused: false,
                        startDate: $dates->startDate,
                        endDate: $dates->endDate,
                        providerName: config('payments.payment_methods.paypal'),
                        providerSubscriptionId: $subscriptionData['id'],
                        renewalCount: 0,
                    )
                );

                $payment = $this->paymentRepository->create(
                    new PaymentData(
                        userId:  $user->id,
                        modelId: $subscription->id,
                        modelType: Subscription::class,
                        status: $subscriptionData['status'] == 'ACTIVE' ?
                            config('payments.transaction_statuses.completed') :
                            config('payments.transaction_statuses.pending'),
                        paymentMethod: config('payments.payment_methods.paypal'),
                        amount: $subscriptionData['billing_info']['last_payment']['amount']['value'],
                        currency: $subscriptionData['billing_info']['last_payment']['amount']['currency_code'],
                        transactionData: json_encode($subscriptionData),
                        paymentDate: Carbon::parse($subscriptionData['billing_info']['last_payment']['time'])->format('Y-m-d H:i:s')
                    )
                );

                Mail::to($user->email)->queue(new SubscriptionSuccess($user, $plan, $dates->startDate, $dates->endDate));
                RewardTeacherForStudentsSubscription::dispatch($subscription);
            }
        });
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            $subscriptionId = $request->input('resource.id');

            switch ($request->input('event_type')) {
                case config('payments.paypal.events.activated'):
                    $this->activateSubscription($request);
                    break;
                case config('payments.paypal.events.payment_completed'):
                    $this->renewSubscription($request->input('resource.billing_agreement_id'));
                    break;
                case config('payments.paypal.events.cancelled'):
                    $this->subscriptionRepository->cancelPayPalSubscription($subscriptionId);
                    break;
                case config('payments.paypal.events.suspended'):
                    $this->subscriptionRepository->pausePayPalSubscription($subscriptionId);
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Failed to handle webhook: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return $this->respondWithSuccess([
            'message' => __('Webhook has been received')
        ]);
    }


    public function detectCurrencyCode($paymentMethod): string
    {
        switch ($paymentMethod) {
            case config('payments.payment_methods.paypal'):
                return config('payments.currencies.euro');
        }
    }

    public function getSubscriptionPrice(Plan $plan, $paymentProvider) : int
    {
        return $plan->getPriceInCurrency($this->detectCurrencyCode($paymentProvider));
    }
}
