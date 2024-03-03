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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('model_id')->unsigned();
            $table->string('model_type');
            $table->string('payment_method');
            $table->json('transaction_data')->nullable();
            $table->date('payment_date');
            $table->float('amount')->unsigned();
            $table->string('currency');
            $table->string('status');
            $table->timestamps();

            $table->index(['model_id', 'model_type'], 'payments_model_id_model_type_index');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
