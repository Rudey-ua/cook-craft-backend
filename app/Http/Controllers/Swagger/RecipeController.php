<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Post(
 *       path="/api/recipe",
 *       summary="Create a new recipe",
 *       tags={"Recipes"},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\MediaType(
 *               mediaType="multipart/form-data",
 *               @OA\Schema(
 *                   type="object",
 *                   @OA\Property(property="userId", type="integer", description="User ID", example=1),
 *                   @OA\Property(property="title", type="string", description="Recipe title", example="Chocolate Cake"),
 *                   @OA\Property(property="description", type="string", description="Recipe description", example="A delicious and easy-to-make chocolate cake."),
 *                   @OA\Property(property="cooking_time", type="integer", description="Cooking time in minutes", example=120),
 *                   @OA\Property(property="difficulty_level", type="string", description="Difficulty level", enum={"easy", "medium", "hard"}, example="medium"),
 *                   @OA\Property(property="portions", type="integer", description="Number of portions", example=8),
 *                   @OA\Property(property="is_approved", type="boolean", description="Is the recipe approved?", example=true),
 *                   @OA\Property(property="is_published", type="boolean", description="Is the recipe published?", example=true),
 *                   @OA\Property(property="cover_photo", type="string", format="binary", description="Cover photo file"),
 *                   @OA\Property(
 *                       property="ingredients",
 *                       type="array",
 *                       description="List of ingredients",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="title", type="string", description="Ingredient title", example="Flour"),
 *                           @OA\Property(property="measure", type="string", description="Measurement unit", example="grams"),
 *                           @OA\Property(property="count", type="integer", description="Quantity", example=500)
 *                       )
 *                   ),
 *                   @OA\Property(
 *                       property="steps",
 *                       type="array",
 *                       description="List of steps",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="description", type="string", description="Step description", example="Mix flour and softened butter until crumbly."),
 *                           @OA\Property(
 *                               property="photos",
 *                               type="array",
 *                               @OA\Items(type="string", format="binary", description="Step photo files")
 *                           )
 *                       )
 *                   )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=201,
 *           description="Recipe created successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="id", type="integer", example=22),
 *               @OA\Property(property="user_id", type="integer", example=1),
 *               @OA\Property(property="title", type="string", example="Chocolate Cake"),
 *               @OA\Property(property="description", type="string", example="A delicious and easy-to-make chocolate cake."),
 *               @OA\Property(property="cooking_time", type="integer", example=120),
 *               @OA\Property(property="difficulty_level", type="string", example="medium"),
 *               @OA\Property(property="portions", type="integer", example=8),
 *               @OA\Property(property="is_approved", type="boolean", example=true),
 *               @OA\Property(property="is_published", type="boolean", example=true),
 *               @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photo/665242f0280d43.98726136_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg"),
 *               @OA\Property(
 *                   property="ingredients",
 *                   type="array",
 *                   @OA\Items(
 *                       type="object",
 *                       @OA\Property(property="id", type="integer", example=45),
 *                       @OA\Property(property="title", type="string", example="Flour"),
 *                       @OA\Property(property="measure", type="string", example="grams"),
 *                       @OA\Property(property="count", type="integer", example=500)
 *                   )
 *               ),
 *               @OA\Property(
 *                   property="steps",
 *                   type="array",
 *                   @OA\Items(
 *                       type="object",
 *                       @OA\Property(property="id", type="integer", example=36),
 *                       @OA\Property(property="description", type="string", example="Mix flour and softened butter until crumbly."),
 *                       @OA\Property(
 *                           property="photos",
 *                           type="array",
 *                           @OA\Items(type="string", example="localhost/storage/recipe_step_photos/665242f029f650.05616623_ER-zemfyra.drawio.png")
 *                       )
 *                   )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad Request - Incorrect Data Provided",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Invalid data provided")
 *           )
 *       ),
 *       @OA\Response(
 *           response=500,
 *           description="Internal Server Error",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="An error occurred")
 *           )
 *       ),
 *       security={{"bearerAuth":{}}}
 * )
 * @OA\Get(
 *       path="/api/users/recipe",
 *       summary="Retrieve list of recipes for authenticated user",
 *       tags={"Recipes"},
 *       @OA\Response(
 *           response=200,
 *           description="List of recipes retrieved successfully",
 *           @OA\JsonContent(
 *               type="array",
 *               @OA\Items(
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=25),
 *                   @OA\Property(property="user_id", type="integer", example=14),
 *                   @OA\Property(property="title", type="string", example="Chimichurri Sauce"),
 *                   @OA\Property(property="description", type="string", example="This famous Argentinian chimichurri sauce is perfect for any grilled chicken, meat, or fish. My catering customers love it on garlic crostini with grilled flank steak slices."),
 *                   @OA\Property(property="cooking_time", type="integer", example=120),
 *                   @OA\Property(property="difficulty_level", type="string", enum={"easy", "medium", "hard"}, example="medium"),
 *                   @OA\Property(property="portions", type="integer", example=4),
 *                   @OA\Property(property="is_approved", type="boolean", example=true),
 *                   @OA\Property(property="is_published", type="boolean", example=true),
 *                   @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photos/66524ee229a0d3.71372581_vegetarian-recipes-1.jpg"),
 *                   @OA\Property(
 *                       property="ingredients",
 *                       type="array",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="id", type="integer", example=51),
 *                           @OA\Property(property="title", type="string", example="fresh parsley"),
 *                           @OA\Property(property="measure", type="string", example="cup"),
 *                           @OA\Property(property="count", type="integer", example=1)
 *                       )
 *                   ),
 *                   @OA\Property(
 *                       property="steps",
 *                       type="array",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="id", type="integer", example=42),
 *                           @OA\Property(property="description", type="string", example="Combine parsley, oil, vinegar, oregano, cumin, garlic, hot sauce, and salt in a blender or food processor. Mix on medium speed until ingredients are evenly blended, about 10 seconds."),
 *                           @OA\Property(
 *                               property="photos",
 *                               type="array",
 *                               @OA\Items(type="string", example="localhost/storage/recipe_step_photos/66524ee22f2225.89812296_k_Photo_Recipe_Ramp_Up_2022-02-Air-Fryer-Roasted-Potatoes_IMG_6850.jpeg")
 *                           )
 *                       )
 *                   )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Invalid request parameters")
 *           )
 *       ),
 *       security={{"bearerAuth":{}}}
 *  )
 * @OA\Delete(
 *       path="/api/recipe/{id}",
 *       summary="Delete a recipe",
 *       tags={"Recipes"},
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           description="The ID of the recipe to delete",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Recipe deleted successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Recipe deleted successfully")
 *           )
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Recipe not found",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Recipe with the specified ID not found")
 *           )
 *       ),
 *       @OA\Response(
 *           response=401,
 *           description="Unauthorized",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Authentication credentials were not provided or are invalid")
 *           )
 *       ),
 *       security={{"bearerAuth":{}}}
 *  )
 * @OA\Get(
 *       path="/api/recipe",
 *       summary="Retrieve all recipes",
 *       tags={"Recipes"},
 *       @OA\Response(
 *           response=200,
 *           description="List of recipes retrieved successfully",
 *           @OA\JsonContent(
 *               type="array",
 *               @OA\Items(
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=27),
 *                   @OA\Property(property="user_id", type="integer", example=14),
 *                   @OA\Property(property="title", type="string", example="Chimichurri Sauce"),
 *                   @OA\Property(property="description", type="string", example="This famous Argentinian chimichurri sauce is perfect for any grilled chicken, meat, or fish. My catering customers love it on garlic crostini with grilled flank steak slices."),
 *                   @OA\Property(property="cooking_time", type="integer", example=120),
 *                   @OA\Property(property="difficulty_level", type="string", enum={"easy", "medium", "hard"}, example="medium"),
 *                   @OA\Property(property="portions", type="integer", example=4),
 *                   @OA\Property(property="is_approved", type="boolean", example=true),
 *                   @OA\Property(property="is_published", type="boolean", example=true),
 *                   @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photos/6652fff7a26a07.95597645_vegetarian-recipes-1.jpg"),
 *                   @OA\Property(
 *                       property="ingredients",
 *                       type="array",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="id", type="integer", example=55),
 *                           @OA\Property(property="title", type="string", example="fresh parsley"),
 *                           @OA\Property(property="measure", type="string", example="cup"),
 *                           @OA\Property(property="count", type="integer", example=1)
 *                       )
 *                   ),
 *                   @OA\Property(
 *                       property="steps",
 *                       type="array",
 *                       @OA\Items(
 *                           type="object",
 *                           @OA\Property(property="id", type="integer", example=46),
 *                           @OA\Property(property="description", type="string", example="Combine parsley, oil, vinegar, oregano, cumin, garlic, hot sauce, and salt in a blender or food processor. Mix on medium speed until ingredients are evenly blended, about 10 seconds."),
 *                           @OA\Property(
 *                               property="photos",
 *                               type="array",
 *                               @OA\Items(type="string", example="localhost/storage/recipe_step_photos/6652fff7a3ac26.95732310_k_Photo_Recipe_Ramp_Up_2022-02-Air-Fryer-Roasted-Potatoes_IMG_6850.jpeg")
 *                           )
 *                       )
 *                   )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad request",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Invalid request parameters")
 *           )
 *       ),
 *       security={{"bearerAuth":{}}}
 *  )
 * @OA\Get(
 *       path="/api/recipe/{id}",
 *       summary="Retrieve a specific recipe",
 *       tags={"Recipes"},
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           description="The ID of the recipe to retrieve",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Recipe retrieved successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="id", type="integer", example=27),
 *               @OA\Property(property="user_id", type="integer", example=14),
 *               @OA\Property(property="title", type="string", example="Chimichurri Sauce"),
 *               @OA\Property(property="description", type="string", example="This famous Argentinian chimichurri sauce is perfect for any grilled chicken, meat, or fish. My catering customers love it on garlic crostini with grilled flank steak slices."),
 *               @OA\Property(property="cooking_time", type="integer", example=120),
 *               @OA\Property(property="difficulty_level", type="string", enum={"easy", "medium", "hard"}, example="medium"),
 *               @OA\Property(property="portions", type="integer", example=4),
 *               @OA\Property(property="is_approved", type="boolean", example=true),
 *               @OA\Property(property="is_published", type="boolean", example=true),
 *               @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photos/6652fff7a26a07.95597645_vegetarian-recipes-1.jpg"),
 *               @OA\Property(
 *                   property="ingredients",
 *                   type="array",
 *                   @OA\Items(
 *                       type="object",
 *                       @OA\Property(property="id", type="integer", example=55),
 *                       @OA\Property(property="title", type="string", example="fresh parsley"),
 *                       @OA\Property(property="measure", type="string", example="cup"),
 *                       @OA\Property(property="count", type="integer", example=1)
 *                   )
 *               ),
 *               @OA\Property(
 *                   property="steps",
 *                   type="array",
 *                   @OA\Items(
 *                       type="object",
 *                       @OA\Property(property="id", type="integer", example=46),
 *                       @OA\Property(property="description", type="string", example="Combine parsley, oil, vinegar, oregano, cumin, garlic, hot sauce, and salt in a blender or food processor. Mix on medium speed until ingredients are evenly blended, about 10 seconds."),
 *                       @OA\Property(
 *                           property="photos",
 *                           type="array",
 *                           @OA\Items(type="string", example="localhost/storage/recipe_step_photos/6652fff7a3ac26.95732310_k_Photo_Recipe_Ramp_Up_2022-02-Air-Fryer-Roasted-Potatoes_IMG_6850.jpeg")
 *                       )
 *                   )
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Recipe not found",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Recipe with the specified ID not found")
 *           )
 *       ),
 *       security={{"bearerAuth":{}}}
 *  )
 */
class RecipeController
{

}
