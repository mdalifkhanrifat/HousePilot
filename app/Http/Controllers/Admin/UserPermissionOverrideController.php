<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserPermissionOverrideServiceInterface;

class UserPermissionOverrideController extends Controller
{
    protected $service;

    public function __construct(UserPermissionOverrideServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index($userId)
    {
        return response()->json($this->service->getUserOverrides($userId));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
            'type' => 'required|in:grant,deny',
            'reason' => 'nullable|string',
            'expires_at' => 'nullable|date',
            'granted_by' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        return response()->json($this->service->createOverride($data), 201);
    }

    public function destroy($id)
    {
        $this->service->deleteOverride($id);
        return response()->json(['message' => 'Override deleted successfully.']);
    }
}
