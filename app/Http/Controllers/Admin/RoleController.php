<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\RoleServiceInterface;

class RoleController extends Controller
{
    protected $roleService;
    public function __construct(RoleServiceInterface $roleService) {
        $this->roleService = $roleService;
    }
    public function index()       { return response()->json($this->roleService->getAll()); }
    public function show($id)     { return response()->json($this->roleService->getById($id)); }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required', 'slug' => 'required|unique:roles']);
        return response()->json($this->roleService->create($data));
    }
    public function update(Request $request, $id) {
        $data = $request->validate(['name' => 'required', 'slug' => 'required']);
        return response()->json($this->roleService->update($id, $data));
    }
    public function destroy($id)  { return response()->json(['deleted' => $this->roleService->delete($id)]); }
}
