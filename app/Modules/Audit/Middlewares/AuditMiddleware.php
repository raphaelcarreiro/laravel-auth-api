<?php

namespace App\Modules\Audit\Middlewares;

use App\Modules\Audit\Jobs\AuditJob;
use Closure;
use Core\Audit\Application\Dto\AuditInput;
use Core\Audit\Application\UseCases\CreateAuditUseCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class AuditMiddleware
{
    public function __construct(private CreateAuditUseCase $useCase) {}

    public function handle(Request $request, Closure $next): Response
    {
        $input = new AuditInput([
            'request' => json_encode($request->json()->all()),
            'userId' => $request->get('user'),
            'route' => $request->path(),
        ]);

        $this->useCase->execute($input);

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->useCase->update($response->getContent());

        AuditJob::dispatch($this->useCase->output());
    }
}
