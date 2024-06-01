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
        public readonly UploadedFile $coverPhoto,
        public readonly array $ingredients,
        public readonly array $steps,
        public readonly ?array $tags
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
            'cover_photo' => $this->coverPhoto,
        ];
    }
}
