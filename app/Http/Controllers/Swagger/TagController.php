<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Get(
 *      path="/api/tags",
 *      summary="Retrieve available tags",
 *      tags={"Tags"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="Tags retrieved successfully",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="title", type="string", example="healthy")
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
 */
class TagController
{

}
