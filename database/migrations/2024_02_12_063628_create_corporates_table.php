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
        Schema::create('corporates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->text('name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('year_book_day')->nullable();
            $table->string('month_book_day')->nullable();
            $table->string('meal_plan')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporates');
    }
};
