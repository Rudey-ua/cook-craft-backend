<?php

namespace App\Services\Payment;

use App\DataTransferObjects\PaymentData;
use App\DataTransferObjects\SubscriptionData;
use App\DataTransferObjects\SubscriptionDates;
use App\Interfaces\PaymentProviderInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService implements PaymentProviderInterface
{
    use ApiResponseHelpers;
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository,
        protected UserRepository $userRepository,
        protected PaymentRepository $paymentRepository
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
                        startDate: $dates->startDate,
                        expiredDate: $dates->endDate,
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
                        paymentMethod: config('payments.payment_methods.paypal'),
                        transactionData: json_encode($subscriptionData),
                        paymentDate: Carbon::parse($subscriptionData['billing_info']['last_payment']['time'])->format('Y-m-d H:i:s'),
                        amount: $subscriptionData['billing_info']['last_payment']['amount']['value'],
                        currency: $subscriptionData['billing_info']['last_payment']['amount']['currency_code'],
                        status: $subscriptionData['status'] == 'ACTIVE' ?
                            config('payments.transaction_statuses.completed') :
                            config('payments.transaction_statuses.pending'),
                    )
                );
                //TODO: send mail about successful payment
            }
        });
    }

    public function renewSubscription(string $paypalSubscriptionId): void
    {
        if (is_null($subscription = Subscription::where('provider_subscription_id', $paypalSubscriptionId)->first())) {
            Log::channel('subscription')->warning("Subscription not found for PayPal ID: {$paypalSubscriptionId}");
            return;
        }
        $subscriptionData = $this->getSubscriptionData($paypalSubscriptionId);

        if (!empty($subscriptionData['billing_info']['cycle_executions'])) {
            $cycleExecutions = $subscriptionData['billing_info']['cycle_executions'][0];
            if (isset($cycleExecutions['cycles_completed'])){
                if ($cycleExecutions['cycles_completed'] > 1) {
                    //Renewal PayPal subscription
                    $this->subscriptionRepository->renewSubscription($subscription);

                    //Store payment information regarding last transaction
                    $this->paymentRepository->create(
                        new PaymentData(
                            userId:  $subscription->user_id,
                            modelId: $subscription->id,
                            modelType: Subscription::class,
                            paymentMethod: config('payments.payment_methods.paypal'),
                            transactionData: json_encode($subscriptionData),
                            paymentDate: Carbon::parse($subscriptionData['billing_info']['last_payment']['time'])->format('Y-m-d H:i:s'),
                            amount: $subscriptionData['billing_info']['last_payment']['amount']['value'],
                            currency: $subscriptionData['billing_info']['last_payment']['amount']['currency_code'],
                            status: $subscriptionData['status'] == 'ACTIVE' ?
                                config('payments.transaction_statuses.completed') :
                                config('payments.transaction_statuses.pending'),
                        )
                    );
                }
            }
        }
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

    public function detectCurrencyCode($paymentMethod): string
    {
        switch ($paymentMethod) {
            case config('payments.payment_methods.paypal'):
                return config('payments.currencies.euro');
        }
    }

    public function getSubscriptionDates(string $time): SubscriptionDates
    {
        //TODO: unify subscription data shift
        $startTime = Carbon::parse($time);
        $endTime = $startTime->copy()->addMonth();

        return new SubscriptionDates($startTime->format('Y-m-d'), $endTime->format('Y-m-d'));
    }

    public function getSubscriptionPrice(Plan $plan, $paymentProvider) : int
    {
        return $plan->getPriceInCurrency($this->detectCurrencyCode($paymentProvider));
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
            }
        } catch (\Exception $e) {
            Log::error("Failed to handle webhook: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return $this->respondWithSuccess([
            'message' => __('Webhook has been received')
        ]);
    }
}
