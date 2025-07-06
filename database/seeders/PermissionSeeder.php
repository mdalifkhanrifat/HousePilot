<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // 🧑 User Management
            ['name' => 'View Users', 'slug' => 'view_users', 'group' => 'users', 'module' => 'admin', 'action' => 'view'],
            ['name' => 'Create User', 'slug' => 'create_user', 'group' => 'users', 'module' => 'admin', 'action' => 'create'],
            ['name' => 'Edit User', 'slug' => 'edit_user', 'group' => 'users', 'module' => 'admin', 'action' => 'edit'],
            ['name' => 'Delete User', 'slug' => 'delete_user', 'group' => 'users', 'module' => 'admin', 'action' => 'delete'],

            // 👤 Role Management
            ['name' => 'View Roles', 'slug' => 'view_roles', 'group' => 'roles', 'module' => 'admin', 'action' => 'view'],
            ['name' => 'Create Role', 'slug' => 'create_role', 'group' => 'roles', 'module' => 'admin', 'action' => 'create'],
            ['name' => 'Edit Role', 'slug' => 'edit_role', 'group' => 'roles', 'module' => 'admin', 'action' => 'edit'],
            ['name' => 'Delete Role', 'slug' => 'delete_role', 'group' => 'roles', 'module' => 'admin', 'action' => 'delete'],

            // 🔒 Permission Management
            ['name' => 'Manage Permissions', 'slug' => 'manage_permissions', 'group' => 'permissions', 'module' => 'admin', 'action' => 'manage'],

            // ⚙️ Settings
            ['name' => 'Access Settings', 'slug' => 'access_settings', 'group' => 'settings', 'module' => 'admin', 'action' => 'access'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                array_merge($perm, ['is_system' => true, 'is_active' => true])
            );
        }
    }
}
