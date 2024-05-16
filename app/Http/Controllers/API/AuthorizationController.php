<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\UserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function __construct(protected  UserRepository $userRepository)
    {
    }

    use ApiResponseHelpers;
    public function register(RegisterRequest $request) : JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = $this->userRepository->create(
                new UserData(
                    firstName: $validated['firstName'],
                    lastName: $validated['lastName'],
                    email: $validated['email'],
                    password: $validated['password'],
                    birthDate: $validated['birthDate'],
                    gender: $validated['gender']
                )
            );

            $user->assignRole(config('permission.user_roles.member'));
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->respondWithSuccess([
                'message' => __("Registration successful!"),
                'user' => $user,
                'token' => $token,
            ]);
        });
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userRepository->getUserByEmail($validated['email']);

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->respondUnAuthenticated(__("The provided credentials are incorrect."));
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => __("Login successful!"),
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(['message' => 'Logged out successfully']);
    }
}
