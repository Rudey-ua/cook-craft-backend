<?php

namespace App\DataTransferObjects;

class StepData
{
    public function __construct(
        public readonly string $description,
        public readonly array $photos
    ) {
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'photos' => $this->photos
        ];
    }
}
