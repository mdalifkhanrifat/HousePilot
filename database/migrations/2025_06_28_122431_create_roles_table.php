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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->nullable()->default('#3b82f6'); // Default blue color
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_system')->default(false); // System roles can't be deleted
            $table->timestamps();

            // Indexes for performance
            $table->index(['is_active', 'sort_order']);
            $table->index('slug');
            $table->index('is_system');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
