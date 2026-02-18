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
        Schema::create('gold_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name', 150);
            $table->integer('duration_months');
            $table->decimal('monthly_emi', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('bonus_amount', 10, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_plans');
    }
};
