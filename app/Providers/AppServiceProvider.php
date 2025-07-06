<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\AuthService;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\RoleRepository;

use App\Services\Interfaces\RoleServiceInterface;
use App\Services\RoleService;


use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\PermissionService;


use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\PermissionRepository;

use App\Services\Interfaces\UserRoleServiceInterface;
use App\Services\UserRoleService;


use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use App\Repositories\UserRoleRepository;


use App\Repositories\Interfaces\PermissionCategoryRepositoryInterface;
use App\Repositories\PermissionCategoryRepository;

use App\Services\Interfaces\PermissionCategoryServiceInterface;
use App\Services\PermissionCategoryService;

use App\Services\Interfaces\RoleHierarchyServiceInterface;
use App\Services\RoleHierarchyService;

use App\Repositories\Interfaces\RoleHierarchyRepositoryInterface;
use App\Repositories\RoleHierarchyRepository;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;




use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


        // Binding repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(UserRoleRepositoryInterface::class, UserRoleRepository::class);
        $this->app->bind(PermissionCategoryRepositoryInterface::class, PermissionCategoryRepository::class);
        $this->app->bind(RoleHierarchyRepositoryInterface::class, RoleHierarchyRepository::class);



        // Binding services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
        $this->app->bind(UserRoleServiceInterface::class, UserRoleService::class);
        $this->app->bind(PermissionCategoryServiceInterface::class,PermissionCategoryService::class);
        $this->app->bind(RoleHierarchyServiceInterface::class, RoleHierarchyService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
        // Passport::hashClientSecrets();

        // Register alias for permission middleware
        Route::aliasMiddleware('permission', CheckPermission::class);
    }
}
