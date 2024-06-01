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
 *
 * @OA\Get(
 *       path="/api/users/profile",
 *       summary="Retrieve user profile",
 *       tags={"Users"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Response(
 *           response=200,
 *           description="Data successfully retrieved!",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Data successfully retrieved!"),
 *               @OA\Property(
 *                   property="data", type="object",
 *                   @OA\Property(property="id", type="integer", example=12),
 *                   @OA\Property(property="firstname", type="string", example="Max"),
 *                   @OA\Property(property="lastname", type="string", example="Kostenko"),
 *                   @OA\Property(property="profile_image", type="string", example=null, nullable=true),
 *                   @OA\Property(property="is_active", type="boolean", example=true),
 *                   @OA\Property(
 *                       property="userDetails", type="object",
 *                       @OA\Property(property="birth_date", type="string", format="date", example="2002-10-11"),
 *                       @OA\Property(property="gender", type="string", example="male"),
 *                       @OA\Property(property="language", type="string", example=null, nullable=true),
 *                       @OA\Property(property="time_zone", type="string", example=null, nullable=true)
 *                   ),
 *                   @OA\Property(
 *                       property="role", type="array",
 *                       @OA\Items(type="object",
 *                           @OA\Property(property="id", type="integer", example=9),
 *                           @OA\Property(property="name", type="string", example="member"),
 *                           @OA\Property(property="guard_name", type="string", example="web"),
 *                           @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-25T17:54:39.000000Z"),
 *                           @OA\Property(property="updated_at", type="string", format="date-time", example="2024-02-25T17:54:39.000000Z"),
 *                           @OA\Property(
 *                               property="pivot", type="object",
 *                               @OA\Property(property="model_type", type="string", example="App\\Models\\User"),
 *                               @OA\Property(property="model_id", type="integer", example=12),
 *                               @OA\Property(property="role_id", type="integer", example=9)
 *                           )
 *                       )
 *                   ),
 *                   @OA\Property(property="is_active_subscription", type="boolean", example=true),
 *                   @OA\Property(property="is_canceled_subscription", type="boolean", example=false)
 *               )
 *           )
 *       )
 *  )
 * @OA\Post(
 *       path="/api/users/update",
 *       summary="Update user profile",
 *       tags={"Users"},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\MediaType(
 *               mediaType="multipart/form-data",
 *               @OA\Schema(
 *                   type="object",
 *                   @OA\Property(property="firstName", type="string"),
 *                   @OA\Property(property="lastName", type="string"),
 *                   @OA\Property(property="email", type="string", format="email"),
 *                   @OA\Property(property="birthDate", type="string", format="date"),
 *                   @OA\Property(property="profileImage", type="string", format="binary"),
 *                   @OA\Property(property="gender", type="string", enum={"male", "female"}),
 *                   @OA\Property(property="language", type="string"),
 *                   @OA\Property(property="timezone", type="string")
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="User profile updated successfully",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="User profile updated successfully"),
 *               @OA\Property(
 *                   property="data", type="object",
 *                   @OA\Property(property="id", type="integer", example=3),
 *                   @OA\Property(property="firstname", type="string", example="Den"),
 *                   @OA\Property(property="lastname", type="string", example="Kostenko"),
 *                   @OA\Property(property="email", type="string", format="email", example="koctenko525@gmail.com"),
 *                   @OA\Property(property="profile_image", type="string", example="https://canteen-app.pp.ua/storage/profile_images/6651dcf7ab7d02.74289847_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg"),
 *                   @OA\Property(property="is_active", type="boolean", example=true),
 *                   @OA\Property(
 *                       property="userDetails", type="object",
 *                       @OA\Property(property="birth_date", type="string", format="date", example="2002-11-10"),
 *                       @OA\Property(property="gender", type="string", example="male"),
 *                       @OA\Property(property="language", type="string", example="ru"),
 *                       @OA\Property(property="time_zone", type="string", example="Europe/Kyiv")
 *                   ),
 *                   @OA\Property(
 *                       property="role", type="array",
 *                       @OA\Items(type="object",
 *                           @OA\Property(property="id", type="integer", example=3),
 *                           @OA\Property(property="name", type="string", example="member"),
 *                           @OA\Property(property="guard_name", type="string", example="web"),
 *                           @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-03T20:08:04.000000Z"),
 *                           @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-03T20:08:04.000000Z"),
 *                           @OA\Property(
 *                               property="pivot", type="object",
 *                               @OA\Property(property="model_type", type="string", example="App\\Models\\User"),
 *                               @OA\Property(property="model_id", type="integer", example=3),
 *                               @OA\Property(property="role_id", type="integer", example=3)
 *                           )
 *                       )
 *                   ),
 *                   @OA\Property(property="is_active_subscription", type="boolean", example=false),
 *                   @OA\Property(property="is_canceled_subscription", type="boolean", example=false)
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
 *       security={{"bearerAuth":{}}}
 *  )
 * @OA\Get(
 *       path="/api/users/favourites",
 *       summary="Retrieve all favourite recipes of the authenticated user",
 *       tags={"Users"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Response(
 *           response=200,
 *           description="Favourite recipes retrieved successfully",
 *           @OA\JsonContent(
 *               type="array",
 *               @OA\Items(
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=13),
 *                   @OA\Property(property="user_id", type="integer", example=14),
 *                   @OA\Property(
 *                       property="recipe",
 *                       type="object",
 *                       @OA\Property(property="id", type="integer", example=34),
 *                       @OA\Property(property="title", type="string", example="Chimichurri Sauce Update"),
 *                       @OA\Property(property="description", type="string", example="This famous Argentinian chimichurri sauce is perfect for any grilled chicken, meat, or fish. My catering customers love it on garlic crostini with grilled flank steak slices."),
 *                       @OA\Property(property="cooking_time", type="integer", example=130),
 *                       @OA\Property(property="difficulty_level", type="string", example="medium"),
 *                       @OA\Property(property="portions", type="integer", example=4),
 *                       @OA\Property(property="is_approved", type="boolean", example=true),
 *                       @OA\Property(property="is_published", type="boolean", example=true),
 *                       @OA\Property(property="cover_photo", type="string", example="localhost/storage/recipe_cover_photos/66531b1015de57.87205594_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg")
 *                   )
 *               )
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
 *       path="/api/subscribe",
 *       summary="Subscribe to an author",
 *       tags={"Users"},
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               type="object",
 *               required={"author_id"},
 *               @OA\Property(property="author_id", type="integer", example=14)
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Subscription successful",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="id", type="integer", example=10),
 *               @OA\Property(
 *                   property="author_id",
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=14),
 *                   @OA\Property(property="firstname", type="string", example="Bahram"),
 *                   @OA\Property(property="profile_image", type="string", example="localhost/storage/profile_images/66536e2ccf5072.24948606_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg")
 *               ),
 *               @OA\Property(
 *                   property="user_id",
 *                   type="object",
 *                   @OA\Property(property="id", type="integer", example=14),
 *                   @OA\Property(property="firstname", type="string", example="Bahram"),
 *                   @OA\Property(property="profile_image", type="string", example="localhost/storage/profile_images/66536e2ccf5072.24948606_23dd31f39f75c3852fd6c1f6a9d915c3662a3f7689970.jpeg")
 *               ),
 *               @OA\Property(property="subscribers_count", type="integer", example=2)
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Bad Request",
 *           @OA\JsonContent(
 *               @OA\Property(property="error", type="string", example="You have already subscribed to this author!")
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
 *        path="/api/unsubscribe",
 *        summary="Unsubscribe from an author",
 *        tags={"Users"},
 *        security={{"bearerAuth":{}}},
 *        @OA\RequestBody(
 *            required=true,
 *            @OA\JsonContent(
 *                type="object",
 *                required={"author_id"},
 *                @OA\Property(property="author_id", type="integer", example=14)
 *            )
 *        ),
 *        @OA\Response(
 *            response=200,
 *            description="Successfully unsubscribed",
 *            @OA\JsonContent(
 *                @OA\Property(property="success", type="string", example="You successfully unsubscribed from the author!")
 *            )
 *        ),
 *        @OA\Response(
 *            response=400,
 *            description="Bad Request",
 *            @OA\JsonContent(
 *                @OA\Property(property="error", type="string", example="Failed to unsubscribe from the author!")
 *            )
 *        ),
 *        @OA\Response(
 *            response=401,
 *            description="Unauthorized",
 *            @OA\JsonContent(
 *                @OA\Property(property="message", type="string", example="Unauthorized")
 *            )
 *        ),
 *        @OA\Response(
 *            response=500,
 *            description="Internal Server Error",
 *            @OA\JsonContent(
 *                @OA\Property(property="message", type="string", example="An error occurred")
 *            )
 *        )
 *   )
 */
class UserController
{

}
