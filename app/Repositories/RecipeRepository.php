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
            //!empty($recipeData->tags) ? $this->syncTags($recipe, $recipeData->tags) : null;

            if (!empty($recipeData->tags)) {
                $this->updateTags($recipe, $recipeData->tags);
            }
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

    /*protected function syncTags(Recipe $recipe, array $tagIds): void
    {
        $recipe->tags()->sync($tagIds);
    }*/

    protected function updateTags(Recipe $recipe, array $tagIds): void
    {
        $recipe->tags()->detach();

        foreach ($tagIds as $tagId) {
            $recipe->tags()->attach($tagId);
        }
    }

    public function updateRecipeWithDetails(int $recipeId, RecipeData $recipeData): Recipe
    {
        return DB::transaction(function () use ($recipeId, $recipeData) {
            $recipe = $this->updateRecipe($recipeId, $recipeData);
            $this->updateIngredients($recipeId, $recipeData->ingredients);
            $this->updateSteps($recipeId, $recipeData->steps);
            //!empty($recipeData->tags) ? $this->syncTags($recipe, $recipeData->tags) : null;

            if (!empty($recipeData->tags)) {
                $this->updateTags($recipe, $recipeData->tags);
            }
            return $recipe;
        });
    }

    protected function updateRecipe(int $recipeId, RecipeData $recipeData): Recipe
    {
        $recipe = $this->recipeModel->findOrFail($recipeId);
        $recipeDataArray = $recipeData->toArray();

        if (!empty($recipeData->coverPhoto)) {
            if (!empty($recipe->cover_photo)) {
                $this->deleteOldCoverRecipeImage($recipe->cover_photo);
            }
            $filename = $this->uploadFile($recipeData->coverPhoto, 'recipe_cover_photos');
            $recipeDataArray['cover_photo'] = $filename;
        }
        $recipe->update($recipeDataArray);

        return $recipe;
    }

    protected function updateIngredients(int $recipeId, array $ingredients): void
    {
        $this->ingredientModel->where('recipe_id', $recipeId)->delete();

        foreach ($ingredients as $ingredientData) {
            $this->ingredientModel->create(array_merge($ingredientData->toArray(), ['recipe_id' => $recipeId]));
        }
    }

    protected function updateSteps(int $recipeId, array $steps): void
    {
        $existingSteps = $this->stepModel->where('recipe_id', $recipeId)->get();

        foreach ($existingSteps as $step) {
            $oldPhotos = json_decode($step->photos, true) ?? [];
            foreach ($oldPhotos as $oldPhoto) {
                $this->deleteOldStepRecipeImage($oldPhoto);
            }
        }
        $this->stepModel->where('recipe_id', $recipeId)->delete();

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
