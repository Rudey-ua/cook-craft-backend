<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(
        protected readonly User $userModel,
    ) {}

    public function getUserById(int $id): ?User
    {
        return $this->userModel->with(['userDetails'])->find($id);
    }
}
