<?php

namespace Core\User\Application\UseCases;

use Core\Shared\Application\Exceptions\BadRequestException;
use Core\User\Application\Dto\CreateUserInput;
use Core\User\Application\Dto\UserOutput;
use Core\User\Domain\UserEntity;
use Core\User\Infra\DB\UserRepositoryInterface;

readonly class CreateUserUseCase
{
    private UserEntity $user;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws BadRequestException
     */
    public function execute(CreateUserInput $dto): UserOutput
    {
        $this->validate($dto);
        $this->create($dto);

        return $this->output();
    }

    private function create(CreateUserInput $dto): void
    {
        $this->user = UserEntity::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);

        $this->repository->create($this->user);
    }

    /**
     * @throws BadRequestException
     */
    private function validate(CreateUserInput $input): void
    {
        $user = $this->repository->findByEmail($input->email);

        if ($user) {
            throw new BadRequestException("user email:{$user->getEmail()} already exists");
        }
    }

    private function output(): UserOutput
    {
        return new UserOutput($this->user->toArray());
    }
}
