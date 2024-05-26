<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Post(
 *      path="/api/favourites",
 *      summary="Add a recipe to the favourite list of the authenticated user",
 *      tags={"Favourites"},
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(
 *          description="Payload to add a recipe to favourites",
 *          required=true,
 *          @OA\JsonContent(
 *              required={"recipe_id"},
 *              @OA\Property(property="recipe_id", type="integer", example=34)
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Recipe added to favourites successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=14),
 *              @OA\Property(property="user_id", type="integer", example=14),
 *              @OA\Property(
 *                  property="recipe",
 *                  type="object",
 *                  @OA\Property(property="id", type="integer", example=34),
 *                  @OA\Property(property="title", type="string", example="Chimichurri Sauce Update"),
 *                  @OA\Property(property="description", type="string", example="This famous Argentinian chimichurri sauce is perfect for any grilled chicken, meat, or fish. My catering customers love it on garlic crostini with grilled flank steak slices."),
 *                  @OA\Property(property="cooking_time", type="integer", example=130),
 *                  @OA\Property(property="difficulty_level", type="string", example="medium"),
 *                  @OA\Property(property="portions", type="integer", example=4),
 *                  @OA\Property(property="is_approved", type="boolean", example=true),
 *                  @OA\Property(property="is_published", type="boolean", example=true),
 *                  @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photos/66531b1015de57.87205594_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg")
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad Request - Error if the recipe is already in the favourite list",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="You already added recipe to favourite list!")
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Unauthorized")
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal Server Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="An error occurred")
 *          )
 *      )
 * )
 * @OA\Delete(
 *       path="/api/favorites/recipes/{id}",
 *       summary="Remove a recipe from the favourite list of the authenticated user",
 *       tags={"Favourites"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           description="Recipe ID",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *       @OA\Response(
 *           response=204,
 *           description="Recipe removed from favourites successfully, no content to return"
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Not Found - Specified recipe doesn't exist in favourites",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Specified recipe doesn't exist!")
 *           )
 *       ),
 *       @OA\Response(
 *           response=401,
 *           description="Unauthorized",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Unauthorized")
 *           )
 *       ),
 *       @OA\Response(
 *           response=500,
 *           description="Internal Server Error",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="An error occurred")
 *           )
 *       )
 *  )
 */
class FavouriteController
{

}
