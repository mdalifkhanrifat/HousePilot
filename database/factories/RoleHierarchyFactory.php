<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\RoleHierarchy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoleHierarchy>
 */
class RoleHierarchyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleHierarchy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_role_id' => Role::factory(),
            'child_role_id' => Role::factory(),
            'level' => $this->faker->numberBetween(1, 5),
            'inherit_permissions' => $this->faker->boolean(80), // 80% chance of true
        ];
    }

    /**
     * Create a hierarchy with inheritance enabled.
     */
    public function withInheritance(): static
    {
        return $this->state(fn (array $attributes) => [
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create a hierarchy with inheritance disabled.
     */
    public function withoutInheritance(): static
    {
        return $this->state(fn (array $attributes) => [
            'inherit_permissions' => false,
        ]);
    }

    /**
     * Create a hierarchy at a specific level.
     */
    public function atLevel(int $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => $level,
        ]);
    }

    /**
     * Create a hierarchy with existing roles.
     */
    public function withRoles(int $parentRoleId, int $childRoleId): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_role_id' => $parentRoleId,
            'child_role_id' => $childRoleId,
        ]);
    }

    /**
     * Create a simple parent-child relationship (level 1).
     */
    public function simpleHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 1,
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create a deep hierarchy (level 3+).
     */
    public function deepHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => $this->faker->numberBetween(3, 5),
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create SAAS Admin hierarchy structure.
     */
    public function saasAdminHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 1,
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create Company Admin hierarchy structure.
     */
    public function companyAdminHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 2,
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create Department Manager hierarchy structure.
     */
    public function departmentManagerHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 3,
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create Employee hierarchy structure.
     */
    public function employeeHierarchy(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 4,
            'inherit_permissions' => true,
        ]);
    }

    /**
     * Create a complete hierarchy chain.
     * This will create multiple hierarchies in a chain.
     */
    public static function createHierarchyChain(array $roleIds): array
    {
        $hierarchies = [];

        for ($i = 0; $i < count($roleIds) - 1; $i++) {
            $hierarchies[] = RoleHierarchy::factory()
                ->withRoles($roleIds[$i], $roleIds[$i + 1])
                ->atLevel($i + 1)
                ->withInheritance()
                ->create();
        }

        return $hierarchies;
    }

    /**
     * Create a multi-tenant hierarchy structure.
     */
    public static function createMultiTenantHierarchy(): array
    {
        // Create roles first
        $superAdmin = Role::factory()->create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        $platformAdmin = Role::factory()->create(['name' => 'Platform Admin', 'slug' => 'platform-admin']);
        $tenantAdmin = Role::factory()->create(['name' => 'Tenant Admin', 'slug' => 'tenant-admin']);
        $tenantManager = Role::factory()->create(['name' => 'Tenant Manager', 'slug' => 'tenant-manager']);
        $tenantUser = Role::factory()->create(['name' => 'Tenant User', 'slug' => 'tenant-user']);

        // Create hierarchy chain
        return self::createHierarchyChain([
            $superAdmin->id,
            $platformAdmin->id,
            $tenantAdmin->id,
            $tenantManager->id,
            $tenantUser->id
        ]);
    }

    /**
     * Create a typical company hierarchy structure.
     */
    public static function createCompanyHierarchy(): array
    {
        // Create company roles
        $ceo = Role::factory()->create(['name' => 'CEO', 'slug' => 'ceo']);
        $director = Role::factory()->create(['name' => 'Director', 'slug' => 'director']);
        $manager = Role::factory()->create(['name' => 'Manager', 'slug' => 'manager']);
        $teamLead = Role::factory()->create(['name' => 'Team Lead', 'slug' => 'team-lead']);
        $employee = Role::factory()->create(['name' => 'Employee', 'slug' => 'employee']);

        // Create hierarchy chain
        return self::createHierarchyChain([
            $ceo->id,
            $director->id,
            $manager->id,
            $teamLead->id,
            $employee->id
        ]);
    }

    /**
     * Create a department-based hierarchy.
     */
    public static function createDepartmentHierarchy(string $department): array
    {
        $departmentUpper = ucfirst($department);

        // Create department-specific roles
        $head = Role::factory()->create([
            'name' => "{$departmentUpper} Head",
            'slug' => strtolower($department) . '-head'
        ]);
        $manager = Role::factory()->create([
            'name' => "{$departmentUpper} Manager",
            'slug' => strtolower($department) . '-manager'
        ]);
        $senior = Role::factory()->create([
            'name' => "Senior {$departmentUpper}",
            'slug' => 'senior-' . strtolower($department)
        ]);
        $junior = Role::factory()->create([
            'name' => "Junior {$departmentUpper}",
            'slug' => 'junior-' . strtolower($department)
        ]);

        // Create hierarchy chain
        return self::createHierarchyChain([
            $head->id,
            $manager->id,
            $senior->id,
            $junior->id
        ]);
    }

    /**
     * Create a project-based hierarchy.
     */
    public static function createProjectHierarchy(): array
    {
        // Create project roles
        $projectManager = Role::factory()->create(['name' => 'Project Manager', 'slug' => 'project-manager']);
        $techLead = Role::factory()->create(['name' => 'Tech Lead', 'slug' => 'tech-lead']);
        $seniorDeveloper = Role::factory()->create(['name' => 'Senior Developer', 'slug' => 'senior-developer']);
        $developer = Role::factory()->create(['name' => 'Developer', 'slug' => 'developer']);
        $juniorDeveloper = Role::factory()->create(['name' => 'Junior Developer', 'slug' => 'junior-developer']);

        // Create hierarchy chain
        return self::createHierarchyChain([
            $projectManager->id,
            $techLead->id,
            $seniorDeveloper->id,
            $developer->id,
            $juniorDeveloper->id
        ]);
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (RoleHierarchy $roleHierarchy) {
            // Log the creation if needed
            Log::info("RoleHierarchy created: Parent Role ID {$roleHierarchy->parent_role_id} -> Child Role ID {$roleHierarchy->child_role_id}");
        });
    }
}
