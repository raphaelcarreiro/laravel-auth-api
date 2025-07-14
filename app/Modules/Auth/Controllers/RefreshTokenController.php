<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Shared\Http\Controllers\Controller;
use Core\Auth\Application\UseCases\RefreshTokenUseCase;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __construct(private readonly RefreshTokenUseCase $useCase)
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function index(Request $request): JsonResponse
    {
        $output = $this->useCase->execute($request->cookie('refresh-token'));

        return $this->response([
            'access_token' => $output->access_token,
            'refresh_token' => $output->refresh_token,
        ])->withCookie($output->access_token_cookie)->withCookie($output->refresh_token_cookie);
    }
}
