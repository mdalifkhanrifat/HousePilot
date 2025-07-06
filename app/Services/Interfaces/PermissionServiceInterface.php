<?php

namespace App\Services\Interfaces;

interface PermissionServiceInterface
{
    /**
     * Retrieve all permissions.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Retrieve a permission by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Create a new permission.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a permission by ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Delete a permission by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);
}
