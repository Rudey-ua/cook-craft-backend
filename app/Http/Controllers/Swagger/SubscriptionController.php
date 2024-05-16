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
 */
class SubscriptionController
{

}
