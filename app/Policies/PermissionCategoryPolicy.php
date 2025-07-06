<?php

namespace App\Policies;

use App\Models\PermissionCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('permission-categories.view') ||
               $user->hasPermission('permission-categories.view-any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PermissionCategory $permissionCategory): bool
    {
        return $user->hasPermission('permission-categories.view') ||
               $user->hasPermission('permission-categories.view-any');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('permission-categories.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PermissionCategory $permissionCategory): bool
    {
        return $user->hasPermission('permission-categories.update') ||
               $user->hasPermission('permission-categories.update-any');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PermissionCategory $permissionCategory): bool
    {
        // Check if user has permission to delete
        if (!$user->hasPermission('permission-categories.delete')) {
            return false;
        }

        // Check if category has permissions (cannot delete if it has permissions)
        if ($permissionCategory->hasPermissions()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PermissionCategory $permissionCategory): bool
    {
        return $user->hasPermission('permission-categories.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PermissionCategory $permissionCategory): bool
    {
        return $user->hasPermission('permission-categories.force-delete');
    }

    /**
     * Determine whether the user can toggle category status.
     */
    public function toggleStatus(User $user, PermissionCategory $permissionCategory): bool
    {
        return $user->hasPermission('permission-categories.toggle-status') ||
               $user->hasPermission('permission-categories.update');
    }

    /**
     * Determine whether the user can update sort order.
     */
    public function updateSortOrder(User $user): bool
    {
        return $user->hasPermission('permission-categories.update-sort-order') ||
               $user->hasPermission('permission-categories.update');
    }

    /**
     * Determine whether the user can bulk update categories.
     */
    public function bulkUpdate(User $user): bool
    {
        return $user->hasPermission('permission-categories.bulk-update') ||
               $user->hasPermission('permission-categories.update-any');
    }

    /**
     * Determine whether the user can export categories data.
     */
    public function export(User $user): bool
    {
        return $user->hasPermission('permission-categories.export') ||
               $user->hasPermission('permission-categories.view-any');
    }

    /**
     * Determine whether the user can import categories data.
     */
    public function import(User $user): bool
    {
        return $user->hasPermission('permission-categories.import') ||
               $user->hasPermission('permission-categories.create');
    }

    /**
     * Determine whether the user can view statistics.
     */
    public function viewStatistics(User $user): bool
    {
        return $user->hasPermission('permission-categories.view-statistics') ||
               $user->hasPermission('permission-categories.view-any');
    }

    /**
     * Determine whether the user can view dashboard data.
     */
    public function viewDashboard(User $user): bool
    {
        return $user->hasPermission('permission-categories.view-dashboard') ||
               $user->hasPermission('permission-categories.view-any');
    }
}
