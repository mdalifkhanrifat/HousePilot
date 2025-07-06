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
        Schema::create('user_permission_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['grant', 'deny']);
            $table->text('reason')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('granted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'permission_id']);
            $table->index(['user_id', 'type']);
            $table->index('expires_at');
            $table->index('granted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permission_overrides');
    }
};
