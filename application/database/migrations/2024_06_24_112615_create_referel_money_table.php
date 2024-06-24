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
        Schema::create('referel_money', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('referel_type',[1,2])->default(1);
            $table->string('referel_code');
            $table->integer('price');
            $table->integer('is_used')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referel_money');
    }
};
