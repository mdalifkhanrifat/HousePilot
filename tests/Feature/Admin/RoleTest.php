<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_role()
    {
        // Arrange
        $user = User::factory()->create();
        $payload = ['name' => 'Manager', 'slug' => 'manager'];

        // Act
        $response = $this->actingAs($user, 'api')->postJson('/api/admin/roles', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Manager']);

        $this->assertDatabaseHas('roles', ['name' => 'Manager']);
    }

    public function test_admin_can_get_roles()
    {
        // Arrange
        Role::factory()->count(3)->create();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user, 'api')->getJson('/api/admin/roles');

        // Assert
        $response->assertOk()
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        '*' => ['id', 'name']
                    ]
                ]);
    }

    public function test_admin_can_update_role()
    {
        // Arrange
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'Old Name']);

        $payload = ['name' => 'Updated Name', 'slug' => 'updated-name'];

        // Act
        $response = $this->actingAs($user, 'api')->putJson("/api/admin/roles/{$role->id}", $payload);

        // Assert
        $response->assertOk()
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('roles', ['name' => 'Updated Name']);
    }

    public function test_admin_can_delete_role()
    {
        // Arrange
        $user = User::factory()->create();
        $role = Role::factory()->create();

        // Act
        $response = $this->actingAs($user, 'api')->deleteJson("/api/admin/roles/{$role->id}");

        // Assert
        $response->assertOk()
                 ->assertJson(['message' => 'Role deleted successfully']);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
