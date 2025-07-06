<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $admin = Role::updateOrCreate([
            'slug' => 'admin'
        ], [
            'name' => 'Admin',
            'description' => 'System Administrator',
            'is_system' => true,
            'is_active' => true,
        ]);

        // Create Editor Role
        $editor = Role::updateOrCreate([
            'slug' => 'editor'
        ], [
            'name' => 'Editor',
            'description' => 'Content Manager',
            'is_system' => false,
            'is_active' => true,
        ]);

        // Assign all permissions to Admin
        $allPermissions = Permission::pluck('id')->toArray();
        $admin->permissions()->sync($allPermissions);

        // Assign limited permissions to Editor
        $editorPermissions = Permission::whereIn('slug', [
            'view_users',
            'edit_user',
            'view_roles',
        ])->pluck('id')->toArray();

        $editor->permissions()->sync($editorPermissions);

    }
}
