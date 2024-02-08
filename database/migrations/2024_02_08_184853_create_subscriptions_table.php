<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $providers = config('payments.payment_methods');

        Schema::create('subscriptions', function (Blueprint $table) use ($providers) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('plan_id')->unsigned();
            $table->string('type');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_canceled')->default(0);
            $table->date('start_date');
            $table->date('expired_date');
            $table->enum('provider_name', array_values($providers))->nullable();
            $table->string('provider_subscription_id');
            $table->integer('renewal_count')->default(0);
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
