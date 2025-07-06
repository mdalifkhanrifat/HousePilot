<?php

namespace App\Repositories;

use App\Models\RoleHierarchy;
use App\Repositories\Interfaces\RoleHierarchyRepositoryInterface;

class RoleHierarchyRepository implements RoleHierarchyRepositoryInterface
{
    public function getAll() {
        return RoleHierarchy::with(['parentRole', 'childRole'])->get();
    }

    public function getById($id) {
        return RoleHierarchy::with(['parentRole', 'childRole'])->findOrFail($id);
    }

    public function create(array $data) {
        return RoleHierarchy::create($data);
    }

    public function update($id, array $data) {
        $item = RoleHierarchy::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete($id) {
        return RoleHierarchy::destroy($id);
    }
}
