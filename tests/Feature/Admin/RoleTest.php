<?php

namespace Tests\Feature\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_role()
    {
        $user = User::factory()->create();

        $payload = ['name' => 'Manager'];

        $response = $this->actingAs($user, 'api')->postJson('/api/admin/roles', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Manager']);

        $this->assertDatabaseHas('roles', ['name' => 'Manager']);
    }

    public function test_admin_can_get_roles()
    {
        Role::factory()->count(3)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/admin/roles');

        $response->assertOk()->assertJsonStructure([['id', 'name']]);
    }

    public function test_admin_can_update_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user, 'api')->putJson("/api/admin/roles/{$role->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('roles', ['name' => 'Updated Name']);
    }

    public function test_admin_can_delete_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson("/api/admin/roles/{$role->id}");

        $response->assertOk()->assertJson(['message' => 'Role deleted successfully.']);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
