<?php

namespace App\DataTransferObjects;

class CommentData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $recipeId,
        public readonly string $title,
        public readonly ?int $rate = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'recipe_id' => $this->recipeId,
            'title' => $this->title,
            'rate' => $this->rate,
        ];
    }
}
