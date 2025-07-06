<?php
namespace App\Repositories\Interfaces;

// interface RoleRepositoryInterface {
//     public function all();
//     public function find($id);
//     public function create(array $data);
//     public function update($id, array $data);
//     public function delete($id);
// }

interface RoleRepositoryInterface
{
    /**
     * সব roles retrieve করে
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * নির্দিষ্ট ID দিয়ে role খুঁজে বের করে
     * @param int $id
     * @return \App\Models\Role
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find($id);

    /**
     * নতুন role তৈরি করে
     * @param array $data
     * @return \App\Models\Role
     */
    public function create(array $data);

    /**
     * existing role update করে
     * @param int $id
     * @param array $data
     * @return \App\Models\Role
     */
    public function update($id, array $data);

    /**
     * role delete করে
     * @param int $id
     * @return bool
     */
    public function delete($id);
}

