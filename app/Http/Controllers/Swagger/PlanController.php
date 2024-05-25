<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Get(
 *      path="/api/plans",
 *      summary="Retrieve available plans",
 *      tags={"Plans"},
 *      security={{"bearerAuth":{}}},
 *      @OA\Response(
 *          response=200,
 *          description="Plans retrieved successfully",
 *          @OA\JsonContent(
 *              type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="id", type="integer", example=1),
 *                  @OA\Property(property="name", type="string", example="Basic - One month"),
 *                  @OA\Property(
 *                      property="price", type="object",
 *                      @OA\Property(property="EUR", type="integer", example=10),
 *                      @OA\Property(property="UAH", type="integer", example=400)
 *                  ),
 *                  @OA\Property(property="type", type="string", enum={"BASIC", "DELUXE"}, example="BASIC")
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
class PlanController
{

}
