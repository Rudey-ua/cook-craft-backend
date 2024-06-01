<?php

namespace App\Services;

use App\DataTransferObjects\IngredientData;
use App\DataTransferObjects\RecipeData;
use App\DataTransferObjects\StepData;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Support\Facades\Log;

class RecipeService
{
    public function __construct(protected RecipeRepository $recipeRepository)
    {
    }

    public function createRecipe($validatedData): Recipe
    {
        $recipeData = $this->mapToRecipeData($validatedData);

        try {
            return $this->recipeRepository->createRecipeWithDetails($recipeData);
        } catch (\Exception $exception) {
            Log::error('Error in creating recipe: ' . $exception->getMessage());
            throw $exception;
        }
    }

    public function updateRecipe(int $recipeId, array $validatedData): Recipe
    {
        $recipeData = $this->mapToRecipeData($validatedData);

        try {
            return $this->recipeRepository->updateRecipeWithDetails($recipeId, $recipeData);
        } catch (\Exception $exception) {
            Log::error('Error in creating recipe: ' . $exception->getMessage());
            throw $exception;
        }
    }

    public function mapToRecipeData(array $validatedData): RecipeData
    {
        return new RecipeData(
            userId: auth()->user()->id,
            title: $validatedData['title'],
            description: $validatedData['description'],
            cooking_time: $validatedData['cooking_time'],
            difficulty_level: $validatedData['difficulty_level'],
            portions: $validatedData['portions'],
            coverPhoto: $validatedData['cover_photo'],
            ingredients: array_map(fn($ingredient) => new IngredientData(
                $ingredient['title'],
                $ingredient['measure'],
                $ingredient['count']
            ), $validatedData['ingredients']),
            steps: array_map(fn($step) => new StepData(
                $step['description'],
                array_map(fn($photo) => $photo, $step['photos'])
            ), $validatedData['steps']),
            tags: $validatedData['tags'] ?? null
        );
    }
}
