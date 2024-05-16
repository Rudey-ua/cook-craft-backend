<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Info(
 *     title="CookCraft API",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * )
 * @OA\SecurityScheme(
 *       type="http",
 *       description="Laravel Sanctum Bearer Token",
 *       name="Bearer",
 *       in="header",
 *       scheme="bearer",
 *       bearerFormat="JWT",
 *       securityScheme="bearerAuth"
 *   )
 */
class MainController
{

}
