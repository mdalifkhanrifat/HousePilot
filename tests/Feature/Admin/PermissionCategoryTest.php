<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\PermissionCategory;

class PermissionCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_permission_category(): void
    {
        $admin = User::factory()->create();

        $payload = [
            'name' => 'Settings',
            'slug' => 'settings',
            'description' => 'App configuration settings',
            'icon' => 'cog',
            'color' => '#f59e0b',
        ];

        $response = $this->actingAs($admin, 'api')->postJson('/api/admin/permission-categories', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Settings']);

        $this->assertDatabaseHas('permission_categories', ['slug' => 'settings']);
    }

    public function test_admin_can_list_permission_categories(): void
    {
        PermissionCategory::factory()->count(2)->create();
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'api')->getJson('/api/admin/permission-categories');

        $response->assertOk()->assertJsonStructure([
            ['id', 'name', 'slug']
        ]);
    }

    public function test_admin_can_update_permission_category(): void
    {
        $admin = User::factory()->create();
        $category = PermissionCategory::factory()->create(['name' => 'Old Category']);

        $response = $this->actingAs($admin, 'api')->putJson(
            "/api/admin/permission-categories/{$category->id}",
            ['name' => 'Updated Category', 'slug' => 'updated-category']
        );

        $response->assertOk()->assertJsonFragment(['name' => 'Updated Category']);

        $this->assertDatabaseHas('permission_categories', ['slug' => 'updated-category']);
    }

    public function test_admin_can_delete_permission_category(): void
    {
        $admin = User::factory()->create();
        $category = PermissionCategory::factory()->create();

        $response = $this->actingAs($admin, 'api')->deleteJson("/api/admin/permission-categories/{$category->id}");

        $response->assertOk()->assertJson(['message' => 'Permission category deleted successfully.']);

        $this->assertDatabaseMissing('permission_categories', ['id' => $category->id]);
    }
}
