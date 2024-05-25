<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Services\RecipeService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    use ApiResponseHelpers;
    public function __construct(protected RecipeService $recipeService)
    {
    }

    public function index()
    {

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
}
