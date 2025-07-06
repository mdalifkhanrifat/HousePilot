<?php

namespace App\Repositories;

use App\Models\PermissionCategory;
use App\Repositories\Interfaces\PermissionCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionCategoryRepository implements PermissionCategoryRepositoryInterface
{
    public function all() {
        return PermissionCategory::orderBy('sort_order')->get();
    }

    public function find($id) {
        return PermissionCategory::findOrFail($id);
    }

    public function create(array $data) {
        return PermissionCategory::create($data);
    }

    public function update($id, array $data) {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id) {
        return PermissionCategory::destroy($id);
    }
}

