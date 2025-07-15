<?php

namespace App\Modules\Shared\Providers;

use App\Modules\Opentelemetry\Providers\OpentelemetryProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(OpentelemetryProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
