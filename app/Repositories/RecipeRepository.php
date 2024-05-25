<?php

namespace App\Repositories;

use App\DataTransferObjects\RecipeData;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Traits\FIleTrait;
use Illuminate\Support\Facades\DB;

class RecipeRepository
{
    use FIleTrait;
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
        $recipeDataArray = $recipeData->toArray();

        if (!empty($recipeData->coverPhoto)) {
            $filename = $this->uploadFile($recipeData->coverPhoto, 'recipe_cover_photos');
            $recipeDataArray['cover_photo'] = $filename;
        }

        return $this->recipeModel->create($recipeDataArray);
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
            $stepDataArray = $stepData->toArray();

            if (!empty($stepData->photos)) {
                $stepDataArray['photos'] = json_encode(array_map(function ($photo) {
                    return $this->uploadFile($photo, 'recipe_step_photos');
                }, $stepData->photos));
            }
            $this->stepModel->create(array_merge($stepDataArray, ['recipe_id' => $recipeId]));
        }
    }
}
