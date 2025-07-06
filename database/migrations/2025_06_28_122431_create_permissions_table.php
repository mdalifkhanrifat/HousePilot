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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('group', 50)->nullable(); // Permission group (users, posts, etc.)
            $table->string('module', 50)->nullable(); // Module (admin, frontend, api)
            $table->string('action', 50)->nullable(); // Action (view, create, edit, delete)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // System permissions can't be deleted
            $table->timestamps();

            // Indexes for performance
            $table->index(['group', 'module', 'action']);
            $table->index('is_active');
            $table->index('is_system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
