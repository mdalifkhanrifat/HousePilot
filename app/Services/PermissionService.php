<?php

namespace App\Services;

use App\Services\Interfaces\PermissionServiceInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService implements PermissionServiceInterface
{
    /**
     * @var PermissionRepositoryInterface
     */
    protected $permissionRepo;

    /**
     * Constructor to bind repository to service.
     *
     * @param PermissionRepositoryInterface $permissionRepo
     */
    public function __construct(PermissionRepositoryInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    /**
     * Get all permissions.
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->permissionRepo->all();
    }

    /**
     * Get permission by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->permissionRepo->find($id);
    }

    /**
     * Create a new permission.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->permissionRepo->create($data);
    }

    /**
     * Update permission by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->permissionRepo->update($id, $data);
    }

    /**
     * Delete permission by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->permissionRepo->delete($id);
    }
}
