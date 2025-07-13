<?php

namespace App\Modules\Shared\Providers;

use App\Modules\Audit\Providers\AuditProvider;
use App\Modules\Auth\Providers\AuthProvider;
use App\Modules\Messenger\Providers\MessengerProvider;
use App\Modules\User\Providers\UserProvider;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(UserProvider::class);
        $this->app->register(AuthProvider::class);
        $this->app->register(AuditProvider::class);
        $this->app->register(MessengerProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
