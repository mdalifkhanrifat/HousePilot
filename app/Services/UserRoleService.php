<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserRoleServiceInterface;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;

class UserRoleService implements UserRoleServiceInterface
{
    protected $userRoleRepository;

    public function __construct(UserRoleRepositoryInterface $userRoleRepository)
    {
        $this->userRoleRepository = $userRoleRepository;
    }

    public function assignRole($userId, $roleId)
    {
        return $this->userRoleRepository->assignRole($userId, $roleId);
    }

    public function removeRole($userId, $roleId)
    {
        return $this->userRoleRepository->removeRole($userId, $roleId);
    }

    public function listRoles($userId)
    {
        return $this->userRoleRepository->listRoles($userId);
    }
}
