<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\RoleServiceInterface;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

// class RoleController extends Controller
// {
//     protected $roleService;

//     public function __construct(RoleServiceInterface $roleService) {
//         $this->roleService = $roleService;
//     }

//     /**
//      * Display a listing of all roles.
//      */
//     public function index() {
//         return response()->json($this->roleService->getAll());
//     }

//     /**
//      * Display the specified role by ID.
//      */
//     public function show($id) {
//         return response()->json($this->roleService->getById($id));
//     }

//     /**
//      * Store a newly created role in storage.
//      */
//     public function store(Request $request) {
//         // Validate incoming request
//         $data = $request->validate([
//             'name' => 'required',
//             'slug' => 'required|unique:roles'
//         ]);

//         // Create the role using the service
//         $role = $this->roleService->create($data);

//         // Return success response
//         return response()->json([
//             'message' => 'Role created successfully.',
//             'data' => $role
//         ], 201);
//     }

//     /**
//      * Update the specified role in storage.
//      */
//     public function update(Request $request, $id) {
//         // Validate request data
//         $data = $request->validate([
//             'name' => 'required',
//             'slug' => 'required'
//         ]);

//         // Update role
//         return response()->json($this->roleService->update($id, $data));
//     }

//     /**
//      * Remove the specified role from storage.
//      */
//     public function destroy($id) {
//         $deleted = $this->roleService->delete($id);

//         // Return deletion response
//         return response()->json([
//             'message' => 'Role deleted successfully.',
//             'deleted' => $deleted
//         ]);
//     }
// }

class RoleController extends Controller
{
    protected $roleService;

    /**
     * Constructor - RoleService inject করে
     */
    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * সব roles list করে
     * GET /api/roles
     */
    public function index(): JsonResponse
    {
        try {
            $roles = $this->roleService->getAll();

            return response()->json([
                'success' => true,
                'message' => 'Roles retrieved successfully',
                'data' => $roles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * নির্দিষ্ট role show করে
     * GET /api/roles/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $role = $this->roleService->getById($id);

            return response()->json([
                'success' => true,
                'message' => 'Role retrieved successfully',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * নতুন role create করে
     * POST /api/roles
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validation rules
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'slug' => 'nullable|string|max:255|unique:roles,slug',
                'description' => 'nullable|string|max:500'
            ]);

            $role = $this->roleService->create($data);

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'data' => $role
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * existing role update করে
     * PUT/PATCH /api/roles/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            // Validation rules - unique validation এ current ID exclude করা
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'slug' => 'nullable|string|max:255|unique:roles,slug,' . $id,
                'description' => 'nullable|string|max:500'
            ]);

            $role = $this->roleService->update($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'data' => $role
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * role delete করে
     * DELETE /api/roles/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->roleService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully',
                'deleted' => $deleted
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

