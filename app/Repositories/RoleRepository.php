<?php
namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * সব roles permissions সহ retrieve করে
     * with('permissions') eager loading করে - N+1 query problem solve করে
     */
    public function all()
    {
        try {
            return Role::with('permissions')->get();
        } catch (\Exception $e) {
            throw new \Exception('Error fetching roles: ' . $e->getMessage());
        }
    }

    /**
     * নির্দিষ্ট ID দিয়ে role খুঁজে বের করে
     * findOrFail() ব্যবহার করলে role না পেলে exception throw করে
     */
    public function find($id)
    {
        try {
            return Role::with('permissions')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Role not found with ID: ' . $id);
        }
    }

    /**
     * নতুন role create করে
     * mass assignment protection এর জন্য $fillable array ব্যবহার করতে হবে Model এ
     */
    public function create(array $data)
    {
        try {
            return Role::create($data);
        } catch (\Exception $e) {
            throw new \Exception('Error creating role: ' . $e->getMessage());
        }
    }

    /**
     * existing role update করে
     * প্রথমে role খুঁজে বের করে, তারপর update করে
     */
    public function update($id, array $data)
    {
        try {
            $role = $this->find($id);
            $role->update($data);
            return $role->fresh('permissions'); // updated data with permissions return করে
        } catch (\Exception $e) {
            throw new \Exception('Error updating role: ' . $e->getMessage());
        }
    }

    /**
     * role delete করে
     * destroy() static method ব্যবহার করে
     */
    public function delete($id)
    {
        try {
            $role = $this->find($id); // check if exists
            return Role::destroy($id);
        } catch (\Exception $e) {
            throw new \Exception('Error deleting role: ' . $e->getMessage());
        }
    }
}
