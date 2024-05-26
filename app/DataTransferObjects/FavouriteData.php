<?php

namespace App\DataTransferObjects;

class FavouriteData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $recipeId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'recipe_id' => $this->recipeId,
        ];
    }
}
