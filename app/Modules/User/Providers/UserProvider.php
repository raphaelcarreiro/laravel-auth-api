<?php

namespace App\Modules\User\Providers;

use Core\User\Infra\DB\Eloquent\UserRepository;
use Core\User\Infra\DB\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user-routes.php');
    }
}
