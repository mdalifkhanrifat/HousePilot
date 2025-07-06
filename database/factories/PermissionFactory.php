<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Permission;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}

