<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\UserPermissionOverride;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    // public function getAllPermissions()
    // {
    //     $basePermissions = $this->roles()
    //         ->with('permissions')
    //         ->get()
    //         ->pluck('permissions')
    //         ->flatten()
    //         ->unique('id');

    //     $grantedOverrides = UserPermissionOverride::where('user_id', $this->id)
    //         ->where('type', 'grant')
    //         ->where('is_active', true)
    //         ->get()
    //         ->pluck('permission');

    //     $deniedOverrides = UserPermissionOverride::where('user_id', $this->id)
    //         ->where('type', 'deny')
    //         ->where('is_active', true)
    //         ->pluck('permission_id');

    //     $finalPermissions = $basePermissions->merge($grantedOverrides)
    //         ->unique('id')
    //         ->reject(fn($perm) => $deniedOverrides->contains($perm->id));

    //     return $finalPermissions;
    // }


    public function hasPermission(string $slug): bool
    {
        // User-specific overrides
        $override = $this->permissionOverrides()
                         ->where('permission_id', Permission::where('slug', $slug)->value('id'))
                         ->first();

        if ($override) {
            return $override->type === 'grant';
        }

        // Check from roles
        return $this->roles()
                    ->whereHas('permissions', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })->exists();
    }


    public function permissionOverrides()
    {
        return $this->hasMany(\App\Models\UserPermissionOverride::class);
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }
}
