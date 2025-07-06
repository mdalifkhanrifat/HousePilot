<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'System Admin',
            'password' => bcrypt('password'), // Default password
        ]);

        //  Attach admin role
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
