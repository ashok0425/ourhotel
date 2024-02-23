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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id');
            $table->integer('user_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->string('room_type')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('final_amount')->nullable();
            $table->integer('discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('tax')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('no_of_adult')->nullable();
            $table->string('no_of_child')->default(0)->nullable();
            $table->integer('no_of_night')->nullable()->default(0);
            $table->integer('no_of_room')->nullable()->default(0);
            $table->timestamp('booked_hour_from')->nullable();
            $table->timestamp('booked_hour_to')->nullable();
            $table->string('booking_start')->nullable();
            $table->string('booking_end')->nullable();
            $table->text('early_reason')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->text('remark')->nullable();
            $table->integer('status')->default(1);
            $table->string('is_paid')->nullable();
            $table->integer('booked_by')->nullable()->default(0);
            $table->string('channel')->nullable();
            $table->string('booking_type')->nullable();
            $table->integer('refer_amount_spent')->nullable();
            $table->integer('refer_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->enum('payment_type',['online','offline'])->default('online');
            $table->json('hotel_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
