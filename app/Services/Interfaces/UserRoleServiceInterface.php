<?php

namespace App\Services\Interfaces;

interface UserRoleServiceInterface
{
    public function assignRole($userId, $roleId);
    public function removeRole($userId, $roleId);
    public function listRoles($userId);
}
