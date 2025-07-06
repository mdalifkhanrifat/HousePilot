<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPermissionOverride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permission_id',
        'type', // 'grant' or 'deny'
        'reason',
        'expires_at',
        'granted_by',
        'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }
}
