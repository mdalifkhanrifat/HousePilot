<?php
namespace App\Services;

use App\Repositories\Interfaces\RoleHierarchyRepositoryInterface;
use App\Services\Interfaces\RoleHierarchyServiceInterface;

class RoleHierarchyService implements RoleHierarchyServiceInterface
{
    protected $repo;

    public function __construct(RoleHierarchyRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function getAll() {
        return $this->repo->getAll();
    }

    public function getById($id) {
        return $this->repo->getById($id);
    }

    public function create(array $data) {
        return $this->repo->create($data);
    }

    public function update($id, array $data) {
        return $this->repo->update($id, $data);
    }

    public function delete($id) {
        return $this->repo->delete($id);
    }
}
