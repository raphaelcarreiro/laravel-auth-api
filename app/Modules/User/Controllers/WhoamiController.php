<?php

namespace App\Modules\User\Controllers;

use App\Modules\Shared\Http\Controllers\Controller;
use App\Modules\User\Requests\CreateUserRequest;
use Core\Shared\Application\Exceptions\BadRequestException;
use Core\User\Application\Dto\CreateUserInput;
use Core\User\Application\UseCases\CreateUserUseCase;
use Core\User\Application\UseCases\WhoamiUseCase;
use Illuminate\Http\JsonResponse;

class WhoamiController extends Controller
{
    public function __construct(private readonly WhoamiUseCase $useCase)
    {
    }

    public function index(): JsonResponse
    {
        $output = $this->useCase->execute();

        return $this->response($output);
    }
}
