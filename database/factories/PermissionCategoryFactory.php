<?php

namespace Database\Factories;

use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PermissionCategoryFactory extends Factory
{
    protected $model = PermissionCategory::class;

    public function definition(): array {
        return [
            'name' => $this->faker->unique()->word(),
            'slug' => Str::slug($this->faker->unique()->word()),
            'description' => $this->faker->sentence(),
            'icon' => 'fa-icon',
            'color' => '#3b82f6',
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true
        ];
    }
}
