<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'group',
        'module', 'action', 'is_active', 'is_system', 'category_id'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PermissionCategory::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permission_overrides')
            ->withPivot(['type', 'reason', 'expires_at', 'is_active'])
            ->withTimestamps();
    }
}
