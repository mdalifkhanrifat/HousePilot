<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Role;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_attach_role_to_user()
    {
        // Arrange
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $role = Role::factory()->create();

        // Act
        $response = $this->actingAs($admin, 'api')->postJson("/api/admin/users/{$user->id}/roles", [
            'role_id' => $role->id,
        ]);

        // Assert
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Role attached successfully.']);

        $this->assertTrue($user->roles()->where('roles.id', $role->id)->exists());
    }

    public function test_admin_can_detach_role_from_user()
    {
        // Arrange
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $user->roles()->attach($role->id);

        // Act
        $response = $this->actingAs($admin, 'api')->deleteJson("/api/admin/users/{$user->id}/roles/{$role->id}");

        // Assert
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Role removed successfully.']);

        $this->assertFalse($user->roles()->where('roles.id', $role->id)->exists());
    }


    public function test_admin_can_list_roles_of_user()
    {
        // Arrange
        $admin = User::factory()->create();
        $user = User::factory()->create();
        $role = Role::factory()->create();

        // dd($role->id);

        $this->assertDatabaseHas('roles', ['id' => $role->id]);
        $this->assertDatabaseHas('users', ['id' => $user->id]);

        $user->roles()->attach((int)$role->id);

        // Act
        $response = $this->actingAs($admin, 'api')->getJson("/api/admin/users/{$user->id}/roles");

        // Assert
        $response->assertStatus(200)
                ->assertJsonFragment(['id' => $role->id]);
    }


}
