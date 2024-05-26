<?php

namespace App\Repositories;

use App\DataTransferObjects\FavouriteData;
use App\Models\Favorite;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class FavouriteRepository
{
    public function __construct(protected Favorite $favorite)
    {
    }

    public function create(FavouriteData $favouriteData): Favorite
    {
        try {
            $favourite = $this->favorite->create($favouriteData->toArray());

        } catch (Throwable $e) {
            Log::error('Error while creating favourite record: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
        return $favourite;
    }

    public function checkIfRecipeInFavouriteList($userId, $recipeId) : bool
    {
        return Favorite::where('user_id', $userId)->where('recipe_id', $recipeId)->exists();
    }
}
