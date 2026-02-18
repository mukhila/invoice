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
        Schema::create('daily_gold_rates', function (Blueprint $table) {
            $table->id();
            $table->date('rate_date')->unique();
            $table->decimal('rate_per_gram', 10, 2);
            $table->foreignId('created_by')->constrained('employees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_gold_rates');
    }
};
