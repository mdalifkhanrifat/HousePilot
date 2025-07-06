<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class RoleService implements RoleServiceInterface
{
    protected $roleRepo;

    /**
     * Constructor - RoleRepository inject করে
     * Dependency Injection pattern ব্যবহার করে
     */
    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    /**
     * সব roles retrieve করে
     * Repository থেকে data নিয়ে additional business logic apply করতে পারে
     */
    public function getAll()
    {
        try {
            $roles = $this->roleRepo->all();

            // Additional business logic যোগ করা যেতে পারে
            // যেমন: filtering, sorting, caching etc.

            return $roles;
        } catch (\Exception $e) {
            Log::error('Error in RoleService@getAll: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * নির্দিষ্ট role retrieve করে
     */
    public function getById($id)
    {
        try {
            return $this->roleRepo->find($id);
        } catch (\Exception $e) {
            Log::error('Error in RoleService@getById: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * নতুন role create করে
     * Business validation এবং additional logic যোগ করা যেতে পারে
     */
    public function create(array $data)
    {
        try {
            // Business logic - slug auto generate করা যেতে পারে
            if (!isset($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            return $this->roleRepo->create($data);
        } catch (\Exception $e) {
            Log::error('Error in RoleService@create: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * existing role update করে
     */
    public function update($id, array $data)
    {
        try {
            // Business logic যোগ করা যেতে পারে
            if (isset($data['name']) && !isset($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            return $this->roleRepo->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Error in RoleService@update: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * role delete করে
     * Business rules check করা যেতে পারে (যেমন: role এ user আছে কিনা)
     */
    public function delete($id)
    {
        try {
            $role = $this->roleRepo->find($id);

            // Business rule check - role এ user আছে কিনা
            if ($role->users()->count() > 0) {
                throw new \Exception('Cannot delete role that has users assigned');
            }

            return $this->roleRepo->delete($id);
        } catch (\Exception $e) {
            Log::error('Error in RoleService@delete: ' . $e->getMessage());
            throw $e;
        }
    }
}



