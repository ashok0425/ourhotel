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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->string('slug');
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
        Schema::dropIfExists('cities');
    }
};
