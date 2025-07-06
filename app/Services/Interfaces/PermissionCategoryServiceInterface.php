<?php

namespace App\Services\Interfaces;

use App\Models\PermissionCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionCategoryServiceInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}

