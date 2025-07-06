<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\PermissionCategoryController;
use App\Http\Controllers\Admin\RoleHierarchyController;
use App\Http\Controllers\Admin\UserPermissionOverrideController;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\Admin\UserController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::post('/forgot-password/otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/reset-password-otp', [AuthController::class, 'resetPasswordWithOtp']);


Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);

    // User Role Management
    Route::post('/users/{user}/roles', [UserRoleController::class, 'attachRole']);
    Route::delete('/users/{user}/roles/{role}', [UserRoleController::class, 'removeRole']);
    Route::get('/users/{user}/roles', [UserRoleController::class, 'listRoles']); // Changed this line
});

/*
|--------------------------------------------------------------------------
| Permission Categories Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::apiResource('permission-categories', PermissionCategoryController::class);
});

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::apiResource('role-hierarchies', RoleHierarchyController::class);
});

Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::apiResource('user-permission-overrides', UserPermissionOverrideController::class);
});


Route::middleware(['auth:api', 'permission:view-users'])->prefix('admin')->group(function () {
    Route::get('/users', function () {
        return response()->json(['message' => 'Authorized access.']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
