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
        Schema::create('role_permission_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 50); // created, updated, deleted, assigned, revoked
            $table->string('model_type', 100); // Role, Permission, User, etc.
            $table->unsignedBigInteger('model_id');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who performed action
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission_logs');
    }
};
