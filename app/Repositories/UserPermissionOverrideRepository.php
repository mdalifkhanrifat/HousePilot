<?php
namespace App\Repositories;

use App\Models\UserPermissionOverride;
use App\Repositories\Interfaces\UserPermissionOverrideRepositoryInterface;

class UserPermissionOverrideRepository implements UserPermissionOverrideRepositoryInterface
{
    public function getByUser($userId)
    {
        return UserPermissionOverride::with('permission')->where('user_id', $userId)->get();
    }

    public function create(array $data)
    {
        return UserPermissionOverride::create($data);
    }

    public function delete($id)
    {
        return UserPermissionOverride::findOrFail($id)->delete();
    }
}
