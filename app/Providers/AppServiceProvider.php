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


use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind interfaces to implementations

        // Binding repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        // Binding services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
        // Passport::hashClientSecrets();
    }
}
