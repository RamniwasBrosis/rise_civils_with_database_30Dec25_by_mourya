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
        Schema::create('orders_confirm', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('ticket_no');
            $table->string('total_amount');
            $table->string('payment_id');
            $table->string('order_id');
            $table->string('coupon_code')->nullable();
            $table->string('status');
            $table->text('offline_tickets');
            $table->string('discount_value')->nullable();
            $table->unsignedInteger('ticket_booking_id');
            $table->foreign('ticket_booking_id')->references('id')->on('orders_confirm')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_confirm');
    }
};
