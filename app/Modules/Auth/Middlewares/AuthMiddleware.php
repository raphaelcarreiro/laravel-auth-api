<?php

namespace App\Modules\Auth\Middlewares;

use Closure;
use Core\Auth\Application\UseCases\AuthCheckUseCase;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class AuthMiddleware
{
    public function __construct(private AuthCheckUseCase $useCase)
    {
    }

    /**
     * @param Closure(Request): (Response)  $next
     * @throws UnauthorizedException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->useCase->execute($request->cookie('access-token'));

        $request->request->set('user', $user->toArray());

        return $next($request);
    }
}
