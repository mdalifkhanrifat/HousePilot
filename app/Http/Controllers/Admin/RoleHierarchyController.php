<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\RoleHierarchyServiceInterface;

class RoleHierarchyController extends Controller
{
    protected $service;

    public function __construct(RoleHierarchyServiceInterface $service) {
        $this->service = $service;
    }

    public function index() {
        return response()->json($this->service->getAll());
    }

    public function show($id) {
        return response()->json($this->service->getById($id));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'parent_role_id' => 'required|exists:roles,id',
            'child_role_id' => 'required|exists:roles,id',
            'level' => 'nullable|integer',
            'inherit_permissions' => 'nullable|boolean',
        ]);
        return response()->json($this->service->create($data), 201);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'parent_role_id' => 'required|exists:roles,id',
            'child_role_id' => 'required|exists:roles,id',
            'level' => 'nullable|integer',
            'inherit_permissions' => 'nullable|boolean',
        ]);
        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id) {

        return response()->json(['message' => 'Role hierarchy deleted successfully.','deleted' => $this->service->delete($id)]);
    }


}
