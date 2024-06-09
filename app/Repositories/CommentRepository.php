<?php

namespace App\Repositories;

use App\DataTransferObjects\CommentData;
use App\Models\Comment;
use App\Models\Recipe;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class CommentRepository
{
    public function __construct(protected Comment $comment)
    {}

    public function findById(int $id) : Comment
    {
        return $this->comment->findOrFail($id);
    }

    public function create(CommentData $commentData): Comment
    {
        try {
            $comment = $this->comment->create($commentData->toArray());

        } catch (Throwable $e) {
            Log::error('Error while creating comment record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $comment;
    }

    public function update(CommentData $commentData, int $id): Comment
    {
        $comment = $this->findById($id);

        try {
            $comment->update($commentData->toArray());

        } catch (Throwable $e) {
            Log::error('Error while updating comment record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $comment;
    }

    public function isMoreThanOneCommentFromUser(int $userId, int $recipeId): bool
    {
        $count = Comment::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->count();
        return $count > 0;
    }
}
