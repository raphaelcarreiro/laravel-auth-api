<?php

namespace Core\Auth\Infra\DB;

use Core\Auth\Domain\RefreshTokenEntity;

interface RefreshTokenRepositoryInterface
{
    public function create(RefreshTokenEntity $refreshToken): void;

    public function remove(RefreshTokenEntity $refreshToken): void;
}
