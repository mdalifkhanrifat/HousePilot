<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description',
        'color', 'is_active', 'sort_order', 'is_system'
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['assigned_at', 'assigned_by', 'expires_at', 'is_active'])
            ->withTimestamps();
    }

    public function parentRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_hierarchies',
            'child_role_id', 'parent_role_id')
            ->withPivot(['inherit_permissions', 'level'])
            ->withTimestamps();
    }

    public function childRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_hierarchies',
            'parent_role_id', 'child_role_id')
            ->withPivot(['inherit_permissions', 'level'])
            ->withTimestamps();
    }

    public function hasPermission(string $permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    public function getAllPermissions()
    {
        $permissions = $this->permissions;

        foreach ($this->parentRoles as $parent) {
            if ($parent->pivot->inherit_permissions) {
                $permissions = $permissions->merge($parent->getAllPermissions());
            }
        }

        return $permissions->unique('id');
    }
}
