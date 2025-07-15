<?php

namespace App\Modules\Audit\Jobs;

use Core\Audit\Application\Dto\AuditOutput;
use Core\Audit\Application\UseCases\SendAuditUseCase;
use Core\Shared\Infra\Messenger\MessengerTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AuditJob implements ShouldQueue
{
    use Queueable;
    use MessengerTrait;

    public function __construct(
        private readonly AuditOutput $audit,
    ) {
    }

    public function handle(SendAuditUseCase $useCase): void
    {
        $useCase->execute($this->audit);
    }
}
