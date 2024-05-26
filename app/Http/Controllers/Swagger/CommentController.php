<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Get(
 *      path="/api/recipes/{id}/comments",
 *      summary="Retrieve comments for a specific recipe",
 *      tags={"Comments"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="The id of the recipe to retrieve comments for",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Comments retrieved successfully",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="id", type="integer", example=14),
 *                  @OA\Property(property="title", type="string", example="It's okay"),
 *                  @OA\Property(property="rate", type="integer", example=3),
 *                  @OA\Property(property="recipe_id", type="integer", example=34),
 *                  @OA\Property(
 *                      property="user_id",
 *                      type="object",
 *                      @OA\Property(property="id", type="integer", example=14),
 *                      @OA\Property(property="firstname", type="string", example="Bahram"),
 *                      @OA\Property(property="profile_image", type="string", format="uri", example=null)
 *                  ),
 *                  @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-26 16:50:54")
 *              )
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
 * @OA\Post(
 *       path="/api/comments",
 *       summary="Create a new comment",
 *       tags={"Comments"},
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(
 *           required=true,
 *           description="Data for creating a new comment",
 *           @OA\JsonContent(
 *               type="object",
 *               required={"title", "rate", "recipe_id"},
 *               @OA\Property(property="title", type="string", example="Super!"),
 *               @OA\Property(property="rate", type="integer", example=5),
 *               @OA\Property(property="recipe_id", type="integer", example=34)
 *           )
 *       ),
 *       @OA\Response(
 *           response=201,
 *           description="Comment created successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="id", type="integer", example=15),
 *               @OA\Property(property="title", type="string", example="Super!"),
 *               @OA\Property(property="rate", type="integer", example=5),
 *               @OA\Property(property="recipe_id", type="integer", example=34),
 *               @OA\Property(
 *                   property="user_id",
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=14),
 *                   @OA\Property(property="firstname", type="string", example="Bahram"),
 *                   @OA\Property(property="profile_image", type="string", format="uri", example=null)
 *               ),
 *               @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-26 16:58:23")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad Request",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Invalid input")
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
 * @OA\Post(
 *       path="/api/comments/{id}/update",
 *       summary="Update an existing comment",
 *       tags={"Comments"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           description="The id of the comment to update",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *       @OA\RequestBody(
 *           required=true,
 *           description="Data for updating the comment",
 *           @OA\JsonContent(
 *               type="object",
 *               required={"title", "rate"},
 *               @OA\Property(property="title", type="string", example="It's okay"),
 *               @OA\Property(property="rate", type="integer", example=3)
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Comment updated successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="id", type="integer", example=15),
 *               @OA\Property(property="title", type="string", example="It's okay"),
 *               @OA\Property(property="rate", type="integer", example=3),
 *               @OA\Property(property="recipe_id", type="integer", example=34),
 *               @OA\Property(
 *                   property="user_id",
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=14),
 *                   @OA\Property(property="firstname", type="string", example="Bahram"),
 *                   @OA\Property(property="profile_image", type="string", format="uri", example=null)
 *               ),
 *               @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-26 16:58:23")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad Request",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Invalid input")
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
 *           response=404,
 *           description="Not Found",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Comment not found")
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
 * @OA\Delete(
 *       path="/api/comments/{id}",
 *       summary="Delete a comment",
 *       tags={"Comments"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(
 *           name="id",
 *           in="path",
 *           required=true,
 *           description="The id of the comment to delete",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *       @OA\Response(
 *           response=204,
 *           description="Comment deleted successfully"
 *       ),
 *       @OA\Response(
 *           response=404,
 *           description="Not Found",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Comment not found")
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
class CommentController
{

}
