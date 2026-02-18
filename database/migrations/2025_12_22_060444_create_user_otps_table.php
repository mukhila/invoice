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
        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('otp', 10);
            $table->timestamp('expires_at');
            $table->tinyInteger('is_used')->default(0);
            // No created_at/updated_at requested specifically, but typically migration creates them. 
            // User requested "created_at TIMESTAMP NULL" is NOT listed? 
            // Wait, look closely: "expires_at TIMESTAMP NOT NULL". No created_at in schema text provided.
            // Actually, usually OTP tables need created_at to know when it was made. 
            // But I will follow the user's explicit schema text:
            // "id BIGINT... user_id... otp... expires_at... is_used..." 
            // It does NOT list created_at. I will skip timestamps() helper.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
