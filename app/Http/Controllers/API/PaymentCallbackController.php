<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCallbackController extends Controller
{
    public function __invoke($service, Request $request)
    {
        $services = config('payments.payment_instance');
        if (!array_key_exists($service, $services)) {
            return response()->json(['message' => 'Unknown service'], 404);
        }

        $serviceHandler = app($services[$service]);
        return $serviceHandler->activateSubscription($request);
    }
}
