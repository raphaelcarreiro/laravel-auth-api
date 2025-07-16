<?php

namespace App\Modules\Audit\Providers;

use Core\Audit\Application\UseCases\SendAuditUseCase;
use Core\Audit\Infra\DB\AuditRepositoryInterface;
use Core\Audit\Infra\DB\Elasticsearch\AuditRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AuditProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SendAuditUseCase::class);
        $this->app->bind(AuditRepositoryInterface::class, AuditRepository::class);

        $this->app->singleton(Client::class, function () {
            return ClientBuilder::create()
                ->setHosts([config('elasticsearch.host', 'elasticsearch:9200')])
                ->build();
        });
    }

    public function boot(): void
    {
        //
    }
}
