<?php

namespace App\Services;

use App\Services\Interfaces\PermissionServiceInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService implements PermissionServiceInterface {
    protected $permissionRepo;
    public function __construct(PermissionRepositoryInterface $permissionRepo) {
        $this->permissionRepo = $permissionRepo;
    }
    public function getAll()           { return $this->permissionRepo->all(); }
    public function getById($id)       { return $this->permissionRepo->find($id); }
    public function create(array $data){ return $this->permissionRepo->create($data); }
    public function update($id, array $data){ return $this->permissionRepo->update($id, $data); }
    public function delete($id)        { return $this->permissionRepo->delete($id); }
}
