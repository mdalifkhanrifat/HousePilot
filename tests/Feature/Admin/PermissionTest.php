<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_permission()
    {
        // Arrange
        $user = User::factory()->create();
        $payload = ['name' => 'edit_users', 'slug' => 'edit-users'];

        // Act
        $response = $this->actingAs($user, 'api')->postJson('/api/admin/permissions', $payload);

        // Assert
        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'edit_users']);

        $this->assertDatabaseHas('permissions', ['name' => 'edit_users']);
    }

    public function test_admin_can_get_permissions()
    {
        // Arrange
        Permission::factory()->count(2)->create();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user, 'api')->getJson('/api/admin/permissions');

        // Assert
        $response->assertOk()
                 ->assertJsonStructure([['id', 'name']]);
    }

    public function test_admin_can_update_permission()
    {
        // Arrange
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['name' => 'view_user']);

        $payload = ['name' => 'manage_user', 'slug' => 'manage-user'];

        // Act
        $response = $this->actingAs($user, 'api')->putJson("/api/admin/permissions/{$permission->id}", $payload);

        // Assert
        $response->assertOk()
                 ->assertJsonFragment(['name' => 'manage_user']);

        $this->assertDatabaseHas('permissions', ['name' => 'manage_user']);
    }

    public function test_admin_can_delete_permission()
    {
        // Arrange
        $user = User::factory()->create();
        $permission = Permission::factory()->create();

        // Act
        $response = $this->actingAs($user, 'api')->deleteJson("/api/admin/permissions/{$permission->id}");

        // Assert
        $response->assertOk()
                 ->assertJson(['message' => 'Permission deleted successfully.']);

        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
}
