<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleHierarchy;

use App\Models\Role;

class RoleHierarchySeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        $manager = Role::firstOrCreate(['slug' => 'manager'], ['name' => 'Manager']);
        $editor = Role::firstOrCreate(['slug' => 'editor'], ['name' => 'Editor']);

        RoleHierarchy::create([
            'parent_role_id' => $admin->id,
            'child_role_id' => $manager->id,
            'level' => 1,
            'inherit_permissions' => true
        ]);

        RoleHierarchy::create([
            'parent_role_id' => $manager->id,
            'child_role_id' => $editor->id,
            'level' => 2,
            'inherit_permissions' => true
        ]);
    }
}



