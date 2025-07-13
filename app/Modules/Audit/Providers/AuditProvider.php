<?php

namespace App\Modules\Audit\Providers;

use Core\Audit\Application\UseCases\SendAuditUseCase;
use Illuminate\Support\ServiceProvider;

class AuditProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SendAuditUseCase::class);
    }

    public function boot(): void
    {
        //
    }
}
