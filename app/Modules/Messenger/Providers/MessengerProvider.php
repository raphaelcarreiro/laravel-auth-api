<?php

namespace App\Modules\Messenger\Providers;

use Core\Auth\Infra\DB\Eloquent\Repositories\RefreshTokenRepository;
use Core\Auth\Infra\DB\RefreshTokenRepositoryInterface;
use Core\Shared\Infra\Messenger\Kafka\KafkaMessenger;
use Core\Shared\Infra\Messenger\MessengerInterface;
use Illuminate\Support\ServiceProvider;

class MessengerProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            MessengerInterface::class,
            KafkaMessenger::class
        );
    }

    public function boot(): void
    {
        //
    }
}
