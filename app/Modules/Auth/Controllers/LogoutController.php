<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Shared\Http\Controllers\Controller;
use Core\Auth\Application\UseCases\LogoutUseCase;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function __construct(private readonly LogoutUseCase $useCase)
    {
    }

    public function index(): JsonResponse
    {
        $output = $this->useCase->execute();

        return $this->response(['message' => 'OK'])
            ->withCookie($output->access_token_cookie)
            ->withCookie($output->refresh_token_cookie);
    }
}
