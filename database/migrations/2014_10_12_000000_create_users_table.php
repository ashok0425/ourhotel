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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->boolean('is_partner')->default(false);
            $table->boolean('is_agent')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_corporate')->default(false);
            $table->boolean('isSeoExpert')->default(false);
            $table->string('ip_id')->default(false);
            $table->string('fcm_token')->nullable();
            $table->string('app_fcm_token')->nullable();
            $table->string('address')->nullable();
            $table->string('otp')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
