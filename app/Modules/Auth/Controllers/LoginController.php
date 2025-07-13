<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Shared\Http\Controllers\Controller;
use Core\Auth\Application\Dto\LoginInput;
use Core\Auth\Application\UseCases\LoginUseCase;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(private readonly LoginUseCase $useCase)
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function index(LoginRequest $request): JsonResponse
    {
        $input = new LoginInput($request->validated());

        $output = $this->useCase->execute($input);

        return $this->response([
            'access_token' => $output->access_token,
            'refresh_token' => $output->refresh_token,
        ])->withCookie($output->access_token_cookie)->withCookie($output->refresh_token_cookie);
    }
}
