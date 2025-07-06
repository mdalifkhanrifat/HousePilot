<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\PermissionServiceInterface;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionServiceInterface $permissionService) {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of all permissions.
     */
    public function index() {
        return response()->json($this->permissionService->getAll());
    }

    /**
     * Display the specified permission by ID.
     */
    public function show($id) {
        return response()->json($this->permissionService->getById($id));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request) {
        // Validate the incoming request
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permissions',
        ]);

        // Create the permission
        $permission = $this->permissionService->create($data);

        // Return the created permission with 201 status
        return response()->json($permission, 201);
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, $id) {
        // Validate the request
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        // Update and return the permission
        return response()->json($this->permissionService->update($id, $data));
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy($id) {
        $deleted = $this->permissionService->delete($id);

        // Return deletion confirmation
        return response()->json([
            'message' => 'Permission deleted successfully.',
            'deleted' => $deleted
        ]);
    }
}
