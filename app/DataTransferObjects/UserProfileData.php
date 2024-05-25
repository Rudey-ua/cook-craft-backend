<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class UserProfileData
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $birthDate = null,
        public ?string $language = null,
        public ?string $timeZone = null,
        public ?string $gender = null,
        public ?UploadedFile $profileImage = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            firstName: $data['firstName'] ?? null,
            lastName: $data['lastName'] ?? null,
            email: $data['email'] ?? null,
            birthDate: $data['birthDate'] ?? null,
            language: $data['language'] ?? null,
            timeZone: $data['timezone'] ?? null,
            gender: $data['gender'] ?? null,
            profileImage: $data['profileImage'] ?? null
        );
    }
}
