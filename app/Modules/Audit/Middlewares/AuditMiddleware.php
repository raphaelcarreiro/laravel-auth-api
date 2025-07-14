<?php

namespace App\Modules\Audit\Middlewares;

use App\Modules\Audit\Jobs\AuditJob;
use Closure;
use Core\Audit\Application\Dto\AuditInput;
use Core\Audit\Application\Dto\UpdateAuditInput;
use Core\Audit\Application\Enums\AuditStatusEnum;
use Core\Audit\Application\UseCases\CreateAuditUseCase;
use Core\Shared\Infra\Logger\LoggerTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class AuditMiddleware
{
    use LoggerTrait;

    public function __construct(private CreateAuditUseCase $useCase) {}

    public function handle(Request $request, Closure $next): Response
    {
        $input = new AuditInput([
            'request' => json_encode($request->json()->all()),
            'user_id' => $request->get('user'),
            'route' => $request->uri()
        ]);

        $audit = $this->useCase->execute($input);

        $request->request->set('audit_id', $audit->id->getValue());

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->updateAudit($request, $response);
        $this->handleLog($request, $response);
        $this->dispatchAudit();
    }

    private function updateAudit(Request $request, Response $response): void
    {
        $dto = new UpdateAuditInput([
            'response' => $response->getContent(),
            'user' => $request->get('user'),
            'status_code' => $response->getStatusCode(),
            'route_name' => $request->route()?->getName(),
        ]);

        $this->useCase->update($dto);
    }

    private function handleLog(Request $request, Response $response): void
    {
        $this->log(
            "{$request->getMethod()} {$request->getPathInfo()}",
            [
                'component' => self::class,
                'status' => $response->getStatusCode(),
                'route_name' => $request->route()?->getName(),
                'uri' => $request->uri(),
            ],
            $response->getStatusCode() >= 400 ? 'error' : 'info'
        );
    }

    private function log(string $message, array $extra, string $level): void
    {
        if ($level === 'error') {
            $this->logger()->error($message, ['extra' => $extra]);
            return;
        }

        $this->logger()->info($message, ['extra' => $extra]);
    }

    private function dispatchAudit(): void
    {
        AuditJob::dispatch($this->useCase->output());
    }
}
