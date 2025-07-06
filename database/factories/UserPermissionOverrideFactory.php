<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPermissionOverride>
 */
class UserPermissionOverrideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'permission_id' => Permission::factory(),
            'type' => $this->faker->randomElement(['grant', 'deny']),
            'reason' => $this->faker->sentence,
            'expires_at' => now()->addDays(7),
            'granted_by' => User::factory(),
            'is_active' => true,
        ];
    }
}
