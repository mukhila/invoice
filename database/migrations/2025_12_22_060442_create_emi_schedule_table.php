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
        Schema::create('emi_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_plan_id')->constrained('user_plans');
            $table->integer('emi_month');
            $table->date('due_date');
            $table->decimal('emi_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            // No timestamps requested in schema, but good practice to keep usually. 
            // User schema didn't explicitly ask for timestamps for this one, but did for others? 
            // Actually user schema: created_at TIMESTAMP NULL is NOT present for emi_schedule in the prompt.
            // Wait, "created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL" is NOT in the user prompt for emi_schedule.
            // It just says: "FOREIGN KEY (user_plan_id)..." at the end. Use exact request.
            // Oh, I see "created_at TIMESTAMP NULL" is MISSING for emi_schedule, user_otps lacks updated_at, audit_logs lacks updated_at.
            // I will match the provided schema exactly.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emi_schedule');
    }
};
