<?php

namespace App\Modules\Shared\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ModuleServiceProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
