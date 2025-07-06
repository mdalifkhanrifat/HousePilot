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
        Schema::create('role_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('child_role_id')->constrained('roles')->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->boolean('inherit_permissions')->default(true);
            $table->timestamps();

            $table->unique(['parent_role_id', 'child_role_id']);
            $table->index(['parent_role_id', 'child_role_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_hierarchies');
    }
};
