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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamp('assigned_at')->useCurrent(); // When role was assigned
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null'); // Who assigned
            $table->timestamp('expires_at')->nullable(); // Role expiry (optional)
            $table->boolean('is_active')->default(true); // Can temporarily disable role
            $table->timestamps();

            // Unique constraint
            $table->unique(['user_id', 'role_id']);

            // Indexes for performance
            $table->index('user_id');
            $table->index('role_id');
            $table->index('assigned_by');
            $table->index(['user_id', 'is_active']);
            $table->index('expires_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
