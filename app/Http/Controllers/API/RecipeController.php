<?php

namespace App\Http\Controllers\API;

use App\Events\RecipePublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeRequest;
use App\Http\Resources\PremiumRecipeResource;
use App\Http\Resources\RecipeResource;
use App\Http\Resources\ShortRecipeResource;
use App\Models\Recipe;
use App\Models\User;
use App\Repositories\RecipeRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\RecipeService;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    use ApiResponseHelpers;
    public function __construct(
        protected RecipeService $recipeService,
        protected RecipeRepository $recipeRepository,
        protected SubscriptionRepository $subscriptionRepository)
    {
        //
    }

    public function index()
    {
        return ShortRecipeResource::collection(Recipe::all());
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
            event(new RecipePublished($recipe));
        } catch (\Exception $e) {
            \Log::error("Failed to update recipe, Error: " . $e->getMessage());
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
            \Log::error("Failed to update recipe, Error: " . $e->getMessage());
            return $this->respondError($e->getMessage());
        }
        return new RecipeResource($recipe);
    }

    public function destroy(int $id)
    {
        Recipe::findOrFail($id)->delete();
        return $this->respondNoContent();
    }

    public function getPremiumRecipes()
    {
        if (is_null($this->subscriptionRepository->getActiveSubscription(Auth::id()))) {
            return $this->respondError(__("You don't have an active subscription!"));
        }
        $chiefs = User::role(config('permission.user_roles.chief'))->pluck('id');
        $recipes = Recipe::whereIn('user_id', $chiefs)->get();

        return PremiumRecipeResource::collection($recipes);
    }
}
