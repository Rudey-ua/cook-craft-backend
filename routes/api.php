<?php

use App\Http\Controllers\API\AuthorizationController;
use App\Http\Controllers\API\PaymentCallbackController;
use App\Http\Controllers\API\PaymentWebhookController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\UserController;
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
    Route::post('/auth/register', 'register');
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->middleware('auth:sanctum');
});

Route::group(['middleware' => ['auth:sanctum']],  function() {

    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/profile', 'getProfileData');
        Route::post('/update', 'updateProfile');
    });


    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('/subscription', 'createSubscription');
        Route::post('/subscription/cancel', 'cancelSubscription');
        Route::get('/users/subscription/details', 'getUserSubscriptionInfo');
    });
});

Route::any('/webhooks/payment/{service}', PaymentWebhookController::class);
Route::any('/callback/payment/{service}', PaymentCallbackController::class);
