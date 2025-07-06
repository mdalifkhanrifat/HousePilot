<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PermissionCategoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Response;


class PermissionCategoryController extends Controller
{
    protected $service;

    public function __construct(PermissionCategoryServiceInterface $service) {
        $this->service = $service;
    }

    public function index() {
        return response()->json($this->service->all());
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:permission_categories',
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function show($id) {
        return response()->json($this->service->find($id));
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id) {
        return response()->json(['message' => 'Permission category deleted successfully.','deleted' => $this->service->delete($id)]);
    }
}

