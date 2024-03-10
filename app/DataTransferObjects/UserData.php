<?php

namespace App\DataTransferObjects;

class UserData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $birthDate,
        public readonly string $gender,
    ) {
    }

    public function toArray(): array
    {
        return [
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'birth_date' => $this->birthDate,
            'gender' => $this->gender,
        ];
    }
}
