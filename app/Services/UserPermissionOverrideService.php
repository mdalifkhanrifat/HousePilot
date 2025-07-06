<?php
namespace App\Services;

use App\Repositories\Interfaces\UserPermissionOverrideRepositoryInterface;
use App\Services\Interfaces\UserPermissionOverrideServiceInterface;

class UserPermissionOverrideService implements UserPermissionOverrideServiceInterface
{
    protected $repository;

    public function __construct(UserPermissionOverrideRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserOverrides($userId)
    {
        return $this->repository->getByUser($userId);
    }

    public function createOverride(array $data)
    {
        return $this->repository->create($data);
    }

    public function deleteOverride($id)
    {
        return $this->repository->delete($id);
    }
}
