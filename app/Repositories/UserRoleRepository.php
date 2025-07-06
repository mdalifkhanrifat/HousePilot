<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;

class UserRoleRepository implements UserRoleRepositoryInterface
{
    public function assignRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->syncWithoutDetaching([$roleId]);
        return $user;
    }

    public function removeRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach($roleId);
        return $user;
    }

    public function listRoles($userId)
    {
        $user = User::findOrFail($userId);
        return $user->roles()->get();
    }
}
