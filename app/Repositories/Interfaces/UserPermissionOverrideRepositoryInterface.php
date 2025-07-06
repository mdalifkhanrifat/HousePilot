<?php
namespace App\Repositories\Interfaces;

interface UserPermissionOverrideRepositoryInterface
{
    public function getByUser($userId);
    public function create(array $data);
    public function delete($id);
}
