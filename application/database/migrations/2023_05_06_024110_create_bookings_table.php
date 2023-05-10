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
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->integer('total_price');
            $table->integer('sub_total');
            $table->integer('discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('vat')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('no_of_adult');
            $table->string('no_of_child')->default(0)->nullable();
            $table->string('no_of_night');
            $table->date('check_in');
            $table->date('check_out');
            $table->boolean('is_hourly_booked')->default(false);
            $table->time('booked_hour_from')->nullable();
            $table->time('booked_hour_to')->nullable();
            $table->text('message')->nullable();
            $table->integer('status')->default(1);
            $table->integer('rating')->nullable();
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
