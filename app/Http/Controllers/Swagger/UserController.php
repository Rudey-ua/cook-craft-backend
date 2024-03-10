<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Post(
 *      path="/api/auth/register",
 *      summary="Register a new user",
 *      tags={"Authentication"},
 *      @OA\RequestBody(
 *           required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(
 *                   required={"firstName", "lastName", "email", "password", "birthDate", "gender"},
 *                   @OA\Property(property="firstName", type="string", example="Max"),
 *                   @OA\Property(property="lastName", type="string", example="Kostenko"),
 *                   @OA\Property(property="email", type="string", format="email", example="koctenko525@gmail.com"),
 *                   @OA\Property(property="password", type="string", example="RootRoot123", description="At least 8 characters, including one uppercase letter, one lowercase letter, and one number"),
 *                   @OA\Property(property="birthDate", type="string", format="date", example="2002-10-11"),
 *                   @OA\Property(property="gender", type="string", enum={"male", "female"}, example="male"),
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Registration successful",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Registration successful!"),
 *              @OA\Property(property="user", type="object",
 *                  @OA\Property(property="id", type="integer", example=7),
 *                  @OA\Property(property="firstname", type="string", example="Max"),
 *                  @OA\Property(property="lastname", type="string", example="Kostenko"),
 *                  @OA\Property(property="email", type="string", example="koctenko525@gmail.com")
 *              ),
 *              @OA\Property(property="token", type="string", example="26|B875OphHDAED388Vf42GlIitWT4LdS6dELslEchzf1cdb52e")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Validation Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="The email has already been taken."),
 *              @OA\Property(property="errors", type="object",
 *                  @OA\Property(property="email", type="array",
 *                      @OA\Items(type="string", example="The email has already been taken.")
 *                  )
 *              )
 *          )
 *      )
 *  )
 *
 * @OA\Post(
 *    path="/api/auth/login",
 *    summary="Login as user",
 *    tags={"Authentication"},
 *    @OA\RequestBody(
 *      required=true,
 *      @OA\MediaType(
 *        mediaType="application/json",
 *        @OA\Schema(
 *          required={"email", "password"},
 *          @OA\Property(property="email", type="string", format="email", example="koctenko525@gmail.com"),
 *          @OA\Property(property="password", type="string", example="RootRoot123")
 *        )
 *      )
 *    ),
 *    @OA\Response(
 *      response=200,
 *      description="Login successful",
 *      @OA\JsonContent(
 *        type="object",
 *        @OA\Property(property="message", type="string", example="Login successful!"),
 *        @OA\Property(
 *          property="user", type="object",
 *          @OA\Property(property="id", type="integer", example=7),
 *          @OA\Property(property="firstname", type="string", example="Max"),
 *          @OA\Property(property="lastname", type="string", example="Kostenko"),
 *          @OA\Property(property="email", type="string", format="email", example="koctenko525@gmail.com"),
 *          @OA\Property(property="profile_image", type="string", nullable=true, example=null),
 *          @OA\Property(property="email_verified_at", type="string", nullable=true, example=null),
 *          @OA\Property(property="is_active", type="integer", example=1)
 *        ),
 *        @OA\Property(property="token", type="string", example="27|4vF4kuAbTOcYyyJo9LkuzGNojF7MsVCtAsWAyAUsc818010f")
 *      )
 *    ),
 *    @OA\Response(
 *      response=400,
 *      description="Bad Request - Incorrect Credentials",
 *      @OA\JsonContent(
 *        type="object",
 *        @OA\Property(property="error", type="string", example="The provided credentials are incorrect.")
 *      )
 *    )
 *  )
 *
 * @OA\Post(
 *    path="/api/auth/logout",
 *    operationId="logoutUser",
 *    tags={"Authentication"},
 *    summary="Log out",
 *    description="Logs out the current user by invalidating the token",
 *    security={{"bearerAuth":{}}},
 *    @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *        @OA\Property(property="message", type="string", example="Logged out successfully")
 *      )
 *    ),
 *    @OA\Response(
 *      response=400,
 *      description="Bad Request - Unauthenticated",
 *      @OA\JsonContent(
 *        @OA\Property(property="message", type="string", example="Unauthenticated.")
 *      )
 *    ),
 *    security={
 *      {"bearerAuth": {}}
 *    }
 *  )
 * /
 */
class UserController
{

}
