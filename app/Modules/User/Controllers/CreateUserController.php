<?php

namespace App\Modules\User\Controllers;

use App\Modules\Shared\Http\Controllers\Controller;
use App\Modules\User\Requests\CreateUserRequest;
use Core\Shared\Application\Exceptions\BadRequestException;
use Core\User\Application\Dto\CreateUserInput;
use Core\User\Application\UseCases\CreateUserUseCase;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    public function __construct(private readonly CreateUserUseCase $useCase)
    {
    }

    /**
     * @throws BadRequestException
     */
    public function index(CreateUserRequest $request): JsonResponse
    {
        $input = new CreateUserInput($request->validated());

        $output = $this->useCase->execute($input);

        return $this->response($output);
    }
}
