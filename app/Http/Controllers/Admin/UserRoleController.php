<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Services\Interfaces\UserRoleServiceInterface;

class UserRoleController extends Controller
{
    protected $userRoleService;

    public function __construct(UserRoleServiceInterface $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }

    /**
     * Attach role to user (POST /admin/users/{user}/roles)
     * This method will be called by the test
     */
    public function attachRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        // Check if user already has this role
        if ($user->roles()->where('roles.id', $validated['role_id'])->exists()) {
            return response()->json(['message' => 'User already has this role.'], 409);
        }

        // Use service to attach role
        $this->userRoleService->assignRole($user->id, $validated['role_id']);

        return response()->json(['message' => 'Role attached successfully.']);
    }

    /**
     * Remove role from user (DELETE /admin/users/{user}/roles/{role})
     */
    public function removeRole(User $user, Role $role)
    {
        if (!$user->roles()->where('roles.id', $role->id)->exists()) {
            return response()->json(['message' => 'Role not assigned to user.'], 400);
        }

        // Use service to remove role
        $this->userRoleService->removeRole($user->id, $role->id);

        return response()->json(['message' => 'Role removed successfully.']);
    }

    /**
     * List all roles of a user (GET /admin/users/{user}/roles)
     */
    public function listRoles(User $user)
    {
        $roles = $user->roles()->get();

        return response()->json($roles);
    }

    /**
     * Alternative assign method (if you want to use this approach)
     * This uses $userId instead of User model binding
     */
    public function assignRole(Request $request, $userId)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id']
        ]);

        // Check user exists
        $user = User::findOrFail($userId);

        // Check if user already has this role
        if ($user->roles()->where('roles.id', $validated['role_id'])->exists()) {
            return response()->json(['message' => 'User already has this role.'], 409);
        }

        // Call service to attach role
        $this->userRoleService->assignRole($user->id, $validated['role_id']);

        return response()->json(['message' => 'Role attached successfully.']);
    }
}
