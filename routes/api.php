<?php

use App\Http\Controllers\AuthorizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use F9Web\ApiResponseHelpers;

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

    Route::get('/member/profile', function (Request $request) {
        return response()->json([
            'member' => $request->user()
        ]);
    });
});
