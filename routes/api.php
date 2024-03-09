<?php

use App\Http\Controllers\API\AuthorizationController;
use App\Http\Controllers\API\PaymentCallbackController;
use App\Http\Controllers\API\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthorizationController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::group(['middleware' => ['auth:sanctum']],  function() {

    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('/subscription', 'createSubscription');
    });

    Route::get('/member/profile', function (Request $request) {
        return response()->json([
            'member' => $request->user()
        ]);
    });
});

Route::any('/callback/payment/{service}', PaymentCallbackController::class);

