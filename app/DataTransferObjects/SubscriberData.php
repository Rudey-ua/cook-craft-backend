<?php

namespace App\DataTransferObjects;

class SubscriberData
{
    public function __construct(
        public readonly int $authorId,
        public readonly int $userId
    ) {
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->authorId,
            'user_id' => $this->userId
        ];
    }
}
