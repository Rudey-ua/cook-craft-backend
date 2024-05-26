<?php

namespace App\Repositories;

use App\DataTransferObjects\SubscriberData;
use App\Models\Subscriber;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class SubscriberRepository
{
    public function __construct(protected Subscriber $subscriber)
    {}

    public function create(SubscriberData $subscriberData)
    {
        try {
            $subscriber = $this->subscriber->create($subscriberData->toArray());

        } catch (Throwable $e) {
            Log::error('Error while creating comment record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $subscriber;
    }

    public function checkIfUserAlreadySubscribedOnCreator(int $userId, int $authorId): bool
    {
        return $this->subscriber->where('user_id', $userId)
            ->where('author_id', $authorId)
            ->exists();
    }
}
