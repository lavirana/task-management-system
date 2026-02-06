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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            //user who performed action
            $table->foreignId('user_id')
          ->nullable()
          ->constrained('users')
          ->nullOnDelete();
            //Related task (optional)
            $table->foreignId('task_id')
          ->nullable()
          ->constrained('tasks')
          ->nullOnDelete();
            //Action type
            $table->string('action');
            //Additional details (optional)
            $table->text('details')->nullable();

            //Store changes
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            //Extra Info
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
