<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    use ApiResponseHelpers;
    public function register(RegisterRequest $request) : JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = User::create([
                'firstname' => $validated['firstName'],
                'lastname' => $validated['lastName'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            UserDetails::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'birth_date' => $validated['birthDate'],
                'gender' => $validated['gender'],
            ]);

            $user->assignRole(config('permission.user_roles.member'));
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => __("Registration successful!"),
                'user' => $user,
                'token' => $token,
            ]);
        });
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->respondUnAuthenticated(__("The provided credentials are incorrect."));
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => __("Login successful!"),
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(['message' => 'Logged out successfully']);
    }
}
