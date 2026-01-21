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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->date('due_date');
            $table->unsignedBigInteger('created_by_admin_id')->nullable();
            // Optional: Adds a foreign key constraint
            $table->foreign('created_by_admin_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
