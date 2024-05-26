<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use App\Services\RecipeService;
use F9Web\ApiResponseHelpers;

class RecipeController extends Controller
{
    use ApiResponseHelpers;
    public function __construct(protected RecipeService $recipeService, protected RecipeRepository $recipeRepository)
    {
    }

    public function index()
    {
        return RecipeResource::collection(Recipe::all());
    }

    public function show(int $id)
    {
        $recipe = Recipe::with(['ingredients', 'steps'])->findOrFail($id);
        return new RecipeResource($recipe);
    }


    public function store(RecipeRequest $recipeRequest)
    {
        $validated = $recipeRequest->validated();

        try {
            $recipe = $this->recipeService->createRecipe($validated);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return new RecipeResource($recipe);
    }

    public function update(RecipeRequest $recipeRequest, int $id)
    {
        $validated = $recipeRequest->validated();

        try {
            $recipe = $this->recipeService->updateRecipe($id, $validated);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
        return new RecipeResource($recipe);
    }

    public function destroy(int $id)
    {
        Recipe::findOrFail($id)->delete();
        return $this->respondNoContent();
    }
}
