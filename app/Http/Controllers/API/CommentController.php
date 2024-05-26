<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\CommentData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Recipe;
use App\Repositories\CommentRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(protected CommentRepository $commentRepository)
    {}

    public function show(int $id) : AnonymousResourceCollection
    {
        $recipe = Recipe::findOrFail($id);

        return CommentResource::collection($recipe->comments);
    }

    public function store(CommentRequest $commentRequest) : JsonResponse|CommentResource
    {
        $validated = $commentRequest->validated();

        if ($this->commentRepository->isMoreThanOneCommentFromUser(auth()->user()->id)) {
            return $this->respondError(__("You already commented this recipe!"));
        }

        try {
            $commentData = $this->commentRepository->create(
                new CommentData(
                    userId: auth()->user()->id,
                    recipeId: $validated['recipe_id'],
                    title: $validated['title'],
                    rate: $validated['rate']
                )
            );

        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new CommentResource($commentData);
    }

    public function update(UpdateCommentRequest $commentRequest, int $id)
    {
        $validated = $commentRequest->validated();
        $comment = $this->commentRepository->findById($id);

        try {
            $commentData = $this->commentRepository->update(
                new CommentData(
                    userId: $comment->user_id,
                    recipeId: $comment->recipe->id,
                    title: $validated['title'],
                    rate: $validated['rate']
                ), $id
            );

        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new CommentResource($commentData);
    }

    public function destroy(int $id) : JsonResponse
    {
        //TODO: use Laravel policy for checking permission for deleting the resource
        Comment::findOrFail($id)->delete();
        return $this->respondNoContent();
    }
}
