<?php

namespace App\Modules\Auth\Providers;

use Core\Auth\Infra\DB\Eloquent\Repositories\RefreshTokenRepository;
use Core\Auth\Infra\DB\RefreshTokenRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RefreshTokenRepositoryInterface::class,
            RefreshTokenRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/auth-routes.php');
    }
}
