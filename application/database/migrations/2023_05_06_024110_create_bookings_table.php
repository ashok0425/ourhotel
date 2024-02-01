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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('room_type')->nullable();
            $table->integer('total_price');
            $table->integer('final_amount');
            $table->integer('discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('tax')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('no_of_adult');
            $table->string('no_of_child')->default(0)->nullable();
            $table->integer('no_of_night');
            $table->integer('no_of_room');
            $table->boolean('is_hourly_booked')->default(false);
            $table->timestamp('booked_hour_from')->nullable();
            $table->timestamp('booked_hour_to')->nullable();
            $table->timestamp('booking_start')->nullable();
            $table->timestamp('booking_end')->nullable();
            $table->text('early_reason')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_paid')->default(1);
            $table->integer('booked_by')->default(0);
            $table->string('booking_from')->default(1);
            $table->integer('refer_amount_spent')->nullable();
            $table->integer('refer_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->enum('payment_type',['online','offline'])->default('online');
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
