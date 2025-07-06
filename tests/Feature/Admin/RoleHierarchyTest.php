<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleHierarchy;



class RoleHierarchyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_role_hierarchy()
    {
        $admin = User::factory()->create();
        $parent = Role::factory()->create();
        $child = Role::factory()->create();

        $payload = [
            'parent_role_id' => $parent->id,
            'child_role_id' => $child->id,
            'level' => 1,
            'inherit_permissions' => true,
        ];

        $response = $this->actingAs($admin, 'api')->postJson('/api/admin/role-hierarchies', $payload);

        $response->assertCreated()
                 ->assertJsonFragment(['parent_role_id' => $parent->id]);

        $this->assertDatabaseHas('role_hierarchies', ['parent_role_id' => $parent->id]);
    }

    public function test_admin_can_list_role_hierarchies()
    {
        RoleHierarchy::factory()->count(3)->create();
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'api')->getJson('/api/admin/role-hierarchies');

        $response->assertOk()->assertJsonStructure([['id', 'parent_role_id', 'child_role_id']]);
    }

    public function test_admin_can_delete_role_hierarchy()
    {
        $admin = User::factory()->create();
        $hierarchy = RoleHierarchy::factory()->create();

        $response = $this->actingAs($admin, 'api')->deleteJson("/api/admin/role-hierarchies/{$hierarchy->id}");

        $response->assertOk()->assertJson(['message' => 'Role hierarchy deleted successfully.']);

        $this->assertDatabaseMissing('role_hierarchies', ['id' => $hierarchy->id]);
    }
}

