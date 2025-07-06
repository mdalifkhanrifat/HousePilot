<?php
namespace App\Services\Interfaces;

interface UserPermissionOverrideServiceInterface
{
    public function getUserOverrides($userId);
    public function createOverride(array $data);
    public function deleteOverride($id);
}
