<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PermissionCategory extends Model
{
    // use HasFactory;

    // protected $fillable = [
    //     'name', 'slug', 'description',
    //     'icon', 'color', 'sort_order', 'is_active'
    // ];

    // public function permissions(): HasMany
    // {
    //     return $this->hasMany(Permission::class);
    // }

    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'sort_order',
        'is_active',
    ];
}


