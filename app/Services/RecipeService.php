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
        $recipeData = new RecipeData(
            title: $validatedData['title'],
            description: $validatedData['description'],
            cooking_time: $validatedData['cooking_time'],
            difficulty_level: $validatedData['difficulty_level'],
            portions: $validatedData['portions'],
            is_approved: $validatedData['is_approved'],
            is_published: $validatedData['is_published'],
            coverPhoto: $validatedData['cover_photo'],
            ingredients: array_map(function ($ingredient) {
                return new IngredientData(
                    title: $ingredient['title'],
                    measure: $ingredient['measure'],
                    count: $ingredient['count']
                );
            }, $validatedData['ingredients']),
            steps: array_map(function ($step) {
                return new StepData(
                    description: $step['description'],
                    photos: $step['photos']
                );
            }, $validatedData['steps'])
        );

        try {
            return $this->recipeRepository->createRecipeWithDetails($recipeData);
        } catch (\Exception $exception) {
            Log::error('Error in creating recipe: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
