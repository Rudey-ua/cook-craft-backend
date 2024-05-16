<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Post(
 *      path="/api/subscription",
 *      summary="Create a subscription",
 *      tags={"Subscription"},
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  required={"planId", "paymentMethod"},
 *                  @OA\Property(property="planId", type="integer", example=1),
 *                  @OA\Property(property="paymentMethod", type="string", example="PayPal")
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Subscription created successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Subscription created successfully"),
 *              @OA\Property(
 *                  property="data", type="object",
 *                  @OA\Property(property="provider_name", type="string", example="PayPal"),
 *                  @OA\Property(property="provider_subscription_id", type="string", example="I-A58GRKHDW6Y4"),
 *                  @OA\Property(property="approval_url", type="string", example="https://www.sandbox.paypal.com/webapps/billing/subscriptions?ba_token=BA-7PH45808R52040445")
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Failed to create subscription - Already active subscription",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="error", type="string", example="You already have an active subscription!")
 *          )
 *      )
 * )
 *
 * @OA\Post(
 *       path="/api/subscription/cancel",
 *       summary="Cancel a subscription",
 *       tags={"Subscription"},
 *       security={{"bearerAuth":{}}},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(
 *                   required={"paymentMethod", "reason"},
 *                   @OA\Property(property="paymentMethod", type="string", example="PayPal"),
 *                   @OA\Property(property="reason", type="string", example="I want cancel membership!")
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="Subscription successfully canceled!",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Subscription successfully canceled!")
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Cancellation failed - Subscription already canceled",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="Your subscription already has been canceled!")
 *           )
 *       )
 *  )
 * @OA\Get(
 *       path="/api/users/subscription/details",
 *       summary="Get subscription details",
 *       tags={"Subscription"},
 *       security={{"bearerAuth":{}}},
 *       @OA\Response(
 *           response=200,
 *           description="Subscription data successfully retrieved!",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="message", type="string", example="Subscription data successfully retrieved!"),
 *               @OA\Property(
 *                   property="data", type="object",
 *                   @OA\Property(property="id", type="integer", example=8),
 *                   @OA\Property(property="type", type="string", example="MONTHLY"),
 *                   @OA\Property(property="is_active", type="boolean", example=true),
 *                   @OA\Property(property="is_canceled", type="boolean", example=false),
 *                   @OA\Property(property="start_date", type="string", format="date", example="2024-05-16"),
 *                   @OA\Property(property="expired_date", type="string", format="date", example="2024-06-16"),
 *                   @OA\Property(
 *                       property="plan", type="object",
 *                       @OA\Property(property="id", type="integer", example=1),
 *                       @OA\Property(property="name", type="string", example="Basic - One month"),
 *                       @OA\Property(
 *                           property="price", type="object",
 *                           @OA\Property(property="EUR", type="number", format="float", example=10),
 *                           @OA\Property(property="UAH", type="number", format="float", example=400)
 *                       ),
 *                       @OA\Property(property="type", type="string", example="BASIC"),
 *                       @OA\Property(property="created_at", type="string", format="date-time", example="2024-02-25T17:54:39.000000Z"),
 *                       @OA\Property(property="updated_at", type="string", format="date-time", example="2024-02-25T17:54:39.000000Z")
 *                   ),
 *                   @OA\Property(property="provider_name", type="string", example="PayPal"),
 *                   @OA\Property(property="renewal_count", type="integer", example=0),
 *                   @OA\Property(property="provider_subscription_id", type="string", example="I-H3TK2EJMH5SN"),
 *                   @OA\Property(property="cancel_reason", type="string", nullable=true, example=null)
 *               )
 *           )
 *       ),
 *       @OA\Response(
 *           response=400,
 *           description="Error - No active subscription",
 *           @OA\JsonContent(
 *               type="object",
 *               @OA\Property(property="error", type="string", example="You don't have an active subscription!")
 *           )
 *       )
 *  )
 */
class SubscriptionController
{

}
