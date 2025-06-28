<?php

namespace Tests\Feature\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_permission()
    {
        $user = User::factory()->create();

        $payload = ['name' => 'edit_users'];

        $response = $this->actingAs($user, 'api')->postJson('/api/admin/permissions', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'edit_users']);

        $this->assertDatabaseHas('permissions', ['name' => 'edit_users']);
    }

    public function test_admin_can_get_permissions()
    {
        Permission::factory()->count(2)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/admin/permissions');

        $response->assertOk()->assertJsonStructure([['id', 'name']]);
    }

    public function test_admin_can_update_permission()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['name' => 'view_user']);

        $response = $this->actingAs($user, 'api')->putJson("/api/admin/permissions/{$permission->id}", [
            'name' => 'manage_user',
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['name' => 'manage_user']);

        $this->assertDatabaseHas('permissions', ['name' => 'manage_user']);
    }

    public function test_admin_can_delete_permission()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson("/api/admin/permissions/{$permission->id}");

        $response->assertOk()->assertJson(['message' => 'Permission deleted successfully.']);

        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
}
