<?php

namespace App\Repositories\Interfaces;

interface UserRoleRepositoryInterface
{
    public function assignRole($userId, $roleId);
    public function removeRole($userId, $roleId);
    public function listRoles($userId);
}
