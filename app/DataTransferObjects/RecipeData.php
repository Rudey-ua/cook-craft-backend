<?php

namespace App\DataTransferObjects;

use Illuminate\Http\UploadedFile;

class RecipeData
{
    public function __construct(
        public readonly int $userId,
        public readonly string $title,
        public readonly string $description,
        public readonly int $cooking_time,
        public readonly string $difficulty_level,
        public readonly int $portions,
        public readonly bool $is_approved,
        public readonly bool $is_published,
        public readonly UploadedFile $coverPhoto,
        public readonly array $ingredients,
        public readonly array $steps
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'cooking_time' => $this->cooking_time,
            'difficulty_level' => $this->difficulty_level,
            'portions' => $this->portions,
            'is_approved' => $this->is_approved,
            'is_published' => $this->is_published,
            'cover_photo' => $this->coverPhoto,
        ];
    }
}
