<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class RoleHierarchy extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_role_id', 'child_role_id', 'level', 'inherit_permissions',
    ];

    public function parentRole() {
        return $this->belongsTo(Role::class, 'parent_role_id');
    }

    public function childRole() {
        return $this->belongsTo(Role::class, 'child_role_id');
    }
}
