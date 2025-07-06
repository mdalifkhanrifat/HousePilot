<?php

namespace Database\Seeders;

use App\Models\PermissionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'User Management', 'slug' => 'user-management', 'description' => 'Manage users and roles', 'icon' => 'users', 'color' => '#3b82f6'],
            ['name' => 'Content', 'slug' => 'content', 'description' => 'Manage articles and media', 'icon' => 'file-text', 'color' => '#10b981'],
        ];

        foreach ($categories as $category) {
            PermissionCategory::create($category);
        }

        $this->command->info('Permission categories seeded successfully!');
    }
}
