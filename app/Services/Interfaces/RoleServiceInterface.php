<?php

namespace App\Services\Interfaces;

interface RoleServiceInterface
{
    /**
     * সব roles retrieve করে
     * @return mixed
     */
    public function getAll();

    /**
     * নির্দিষ্ট role retrieve করে
     * @param int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * নতুন role create করে
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * existing role update করে
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * role delete করে
     * @param int $id
     * @return mixed
     */
    public function delete($id);
}
