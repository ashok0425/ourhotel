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
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->float('tax')->nullable();
            $table->string('tour_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('no_of_adult')->nullable();
            $table->string('no_of_child')->default(0)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('remark')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->string('status')->nullable()->default('Pending');
            $table->integer('booked_by')->nullable()->default(0);
            $table->enum('payment_type',['online','offline'])->default('online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_bookings');
    }
};
