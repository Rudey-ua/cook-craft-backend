<?php

namespace App\DataTransferObjects;

class IngredientData
{
    public function __construct(
        public readonly string $title,
        public readonly string $measure,
        public readonly int $count
    ) {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'measure' => $this->measure,
            'count' => $this->count
        ];
    }
}
