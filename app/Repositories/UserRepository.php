<?php

namespace App\Repositories;

use App\DataTransferObjects\UserData;
use App\Models\User;
use App\Models\UserDetails;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserRepository
{
    public function __construct(
        protected readonly User $userModel,
        protected readonly UserDetails $userDetailsModel,
    ) {}

    public function create(UserData $userData): string|User
    {
        try {
            $user = $this->createUser($userData);
            $this->createUserDetails($user->id, $userData);
        } catch (Throwable $e) {
            Log::error('Error while creating user record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $user;
    }

    public function update($userData, User $user)
    {
        try {
            $user->update([
                'firstname' => $userData['firstName'] ?? $user->firstname,
                'lastname' => $userData['lastName'] ?? $user->lastname,
                'email' => $userData['email'] ?? $user->email,
            ]);

            $user->userDetails->update([
                'birth_date' => $userData['birthDate'] ?? $user->userDetails->birth_date,
                'language' => $userData['language'] ?? $user->userDetails->language,
                'time_zone' => $userData['time_zone'] ?? $user->userDetails->time_zone,
                'gender' => $userData['gender'] ?? $user->userDetails->gender,
            ]);

            return $user;
        } catch (Throwable $e) {
            Log::error('Error while updating user record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function createUser(UserData $userData): ?User
    {
        return $this->userModel->create([
            'firstname' => $userData->firstName,
            'lastname' => $userData->lastName,
            'email' => $userData->email,
            'password' => Hash::make($userData->password),
        ]);
    }

    public function createUserDetails(int $userId, UserData $userData): ?UserDetails
    {
        return $this->userDetailsModel->create([
            'user_id' => $userId,
            'birth_date' => $userData->birthDate,
            'gender' => $userData->gender,
        ]);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userModel->with(['userDetails'])->find($id);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userModel->where('email', $email)->first();
    }
}
