<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\SubscriberData;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Repositories\SubscriberRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class SubscriberController extends Controller
{
    use ApiResponseHelpers;
    public function __construct(protected SubscriberRepository $subscriberRepository)
    {
    }

    public function subscribe(SubscriberRequest $subscriberRequest): JsonResponse|SubscriberResource
    {
        $validated = $subscriberRequest->validated();

        if ($this->subscriberRepository->checkIfUserAlreadySubscribedOnCreator(auth()->user()->id, $validated['author_id'])) {
            return $this->respondError(__("You have already subscribed to this author!"));
        }

        try {
            $subscriberData = $this->subscriberRepository->create(
                new SubscriberData(
                    authorId: $validated['author_id'],
                    userId: auth()->user()->id
                )
            );

        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new SubscriberResource($subscriberData);
    }

    public function unsubscribe(SubscriberRequest $subscriberRequest)
    {
        $validated = $subscriberRequest->validated();

        try {
            $deleted = $this->subscriberRepository->destroy(
                new SubscriberData(
                    authorId: $validated['author_id'],
                    userId: auth()->user()->id
                )
            );
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return $deleted
            ? $this->respondOk(__("You successfully unsubscribed from the author!"))
            : $this->respondError(__("Failed to unsubscribe from the author!"));
    }
}
