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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('owner_id')->nullable();
            $table->integer('property_type_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('name')->nullable();
            $table->text('slug')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->json('amenities')->nullable();
            $table->string('price_range')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('rating');
            $table->boolean('pet_friendly')->default(false);
            $table->boolean('couple_friendly')->default(false);
            $table->boolean('corporate')->default(false);
            $table->boolean('top_rated')->default(false);
            $table->string('website')->nullable();
            $table->json('social')->nullable();
            $table->json('opening_hour')->nullable();
            $table->dateTime('full_booked_from')->nullable();
            $table->dateTime('full_booked_to')->nullable();
            $table->integer('is_full_booked')->default(0);
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('mobile_meta_keyword')->nullable();
            $table->text('mobile_meta_description')->nullable();
            $table->string('mobile_meta_title')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
