<?php

namespace App\Repositories;

use App\DataTransferObjects\RecipeData;
use App\DataTransferObjects\UserData;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use App\Models\UserDetails;
use App\Traits\FIleTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecipeRepository
{
    public function __construct(
        protected readonly Recipe $recipeModel,
        protected readonly Ingredient $ingredientModel,
        protected readonly Step $stepModel
    ) {}

    public function createRecipeWithDetails(RecipeData $recipeData): Recipe
    {
        return DB::transaction(function () use ($recipeData) {
            $recipe = $this->createRecipe($recipeData);
            $this->createIngredients($recipe->id, $recipeData->ingredients);
            $this->createSteps($recipe->id, $recipeData->steps);

            return $recipe;
        });
    }

    protected function createRecipe(RecipeData $recipeData): Recipe
    {
        return $this->recipeModel->create($recipeData->toArray());
    }

    protected function createIngredients(int $recipeId, array $ingredients): void
    {
        foreach ($ingredients as $ingredientData) {
            $this->ingredientModel->create(array_merge($ingredientData->toArray(), ['recipe_id' => $recipeId]));
        }
    }

    protected function createSteps(int $recipeId, array $steps): void
    {
        foreach ($steps as $stepData) {
            $this->stepModel->create([
                'recipe_id' => $recipeId,
                'description' => $stepData->description,
                'photos' => json_encode($stepData->photos),
            ]);
        }
    }
}
