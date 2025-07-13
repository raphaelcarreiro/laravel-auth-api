<?php

namespace Core\User\Infra\DB;

use Core\User\Domain\UserEntity;
use Core\User\Domain\UserId;

interface UserRepositoryInterface
{
    public function create(UserEntity $entity): void;

    public function findById(UserId $id, $options = []): UserEntity|null;

    public function findByEmail(string $email): UserEntity|null;
}
