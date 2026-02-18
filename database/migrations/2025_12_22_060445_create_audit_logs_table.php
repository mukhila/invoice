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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 100)->nullable();
            $table->string('table_name', 100)->nullable();
            $table->bigInteger('record_id')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->enum('role', ['SuperAdmin', 'Employee'])->nullable();
            $table->timestamp('created_at')->nullable();
            // User schema: "created_at TIMESTAMP NULL". No updated_at.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
