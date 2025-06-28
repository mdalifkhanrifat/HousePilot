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
    public function index()       { return response()->json($this->permissionService->getAll()); }
    public function show($id)     { return response()->json($this->permissionService->getById($id)); }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required', 'slug' => 'required|unique:permissions']);
        return response()->json($this->permissionService->create($data));
    }
    public function update(Request $request, $id) {
        $data = $request->validate(['name' => 'required', 'slug' => 'required']);
        return response()->json($this->permissionService->update($id, $data));
    }
    public function destroy($id)  { return response()->json(['deleted' => $this->permissionService->delete($id)]); }
}
