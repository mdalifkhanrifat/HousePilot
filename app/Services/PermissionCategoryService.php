<?php

namespace App\Services;

use App\Models\PermissionCategory;
use App\Repositories\Interfaces\PermissionCategoryRepositoryInterface;
use App\Services\Interfaces\PermissionCategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PermissionCategoryService implements PermissionCategoryServiceInterface
{
    protected $repo;

    public function __construct(PermissionCategoryRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function all() {
        return $this->repo->all();
    }

    public function find($id) {
        return $this->repo->find($id);
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
