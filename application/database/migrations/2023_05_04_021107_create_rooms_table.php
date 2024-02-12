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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->integer('onepersonprice');
            $table->integer('twopersonprice')->nullable()->default(0);
            $table->integer('threepersonprice')->nullable()->default(0);
            $table->integer('discount_percent')->nullable()->default(0);
            $table->integer('no_of_room');
            $table->integer('no_of_booked_room')->default(0);
            $table->integer('hourlyprice')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('status')->default(1);
            $table->json('amenity')->nullable();
            $table->string('beds')->nullable();
            $table->string('size')->nullable();
            $table->string('adults')->nullable();
            $table->string('children')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
