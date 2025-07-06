<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Permission;
use App\Models\UserPermissionOverride;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Role;

class UserPermissionOverrideTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_granted_permission_override()
    {
        $user = User::factory()->create();
        $perm = Permission::factory()->create(['slug' => 'edit-posts']);

        UserPermissionOverride::create([
            'user_id' => $user->id,
            'permission_id' => $perm->id,
            'type' => 'grant',
            'is_active' => true,
        ]);

        $this->assertTrue($user->hasPermission('edit-posts'));
    }

    public function test_user_denied_permission_even_if_assigned_by_role()
    {
        $user = User::factory()->create();
        $perm = Permission::factory()->create(['slug' => 'delete-posts']);

        $user->roles()->firstOrCreate([
            'name' => 'Manager',
            'slug' => 'manager'
        ])->permissions()->attach($perm);

        UserPermissionOverride::create([
            'user_id' => $user->id,
            'permission_id' => $perm->id,
            'type' => 'deny',
            'is_active' => true,
        ]);

        $this->assertFalse($user->hasPermission('delete-posts'));
    }

    public function test_user_can_get_permission_from_override()
    {
        // 🅰️ Arrange
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'manage-posts']);

        // Manually override with grant
        UserPermissionOverride::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'type' => 'grant',
            'is_active' => true,
        ]);

        // 🅱️ Act
        $has = $user->hasPermission('manage-posts');

        // 🅲️ Assert
        $this->assertTrue($has);
    }

    public function test_user_permission_denied_if_denied_in_override()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'delete-users']);

        UserPermissionOverride::create([
            'user_id' => $user->id,
            'permission_id' => $permission->id,
            'type' => 'deny',
            'is_active' => true,
        ]);

        $this->assertFalse($user->hasPermission('delete-users'));
    }

    public function test_user_gets_permission_from_role_if_no_override()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'view-dashboard']);

        $role->permissions()->attach($permission->id);
        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasPermission('view-dashboard'));
    }

    public function test_false_if_permission_not_exist()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->hasPermission('non-existent-permission'));
    }

    public function test_user_without_permission_cannot_access()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api')
            ->getJson('/api/admin/users')
            ->assertStatus(403);
    }

}
