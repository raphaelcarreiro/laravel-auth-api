<?php

namespace App\Modules\Shared\Providers;

use App\Modules\Auth\Providers\AuthProvider;
use App\Modules\User\Providers\UserProvider;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(UserProvider::class);
        $this->app->register(AuthProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
