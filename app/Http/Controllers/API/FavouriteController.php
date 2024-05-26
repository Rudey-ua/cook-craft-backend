<?php

namespace App\Http\Controllers\API;

use App\DataTransferObjects\FavouriteData;
use App\Http\Controllers\Controller;
use App\Http\Requests\FavouriteRequest;
use App\Http\Resources\FavouriteResource;
use App\Models\Favorite;
use App\Repositories\FavouriteRepository;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class FavouriteController extends Controller
{
    use ApiResponseHelpers;

    public function __construct(protected FavouriteRepository $favouriteRepository)
    {
    }

    public function show()
    {

    }

    public function store(FavouriteRequest $favouriteRequest)
    {
        $validated = $favouriteRequest->validated();

        if ($this->favouriteRepository->checkIfRecipeInFavouriteList(auth()->user()->id, $validated['recipe_id'])) {
            return $this->respondError(__("You already added recipe to favourite list!"));
        }

        try {
            $commentData = $this->favouriteRepository->create(
                new FavouriteData(
                    userId: auth()->user()->id,
                    recipeId: $validated['recipe_id']
                )
            );

        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new FavouriteResource($commentData);
    }

    public function destroy(int $id) : JsonResponse
    {
        $favourite = Favorite::where('recipe_id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if (is_null($favourite)) {
            return $this->respondNotFound(__("Specified recipe doesn't exist!"));
        }
        $favourite->delete();

        return $this->respondNoContent();
    }
}
