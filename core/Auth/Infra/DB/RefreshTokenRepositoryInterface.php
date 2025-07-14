<?php

namespace Core\Auth\Infra\DB;

use Core\Auth\Domain\RefreshTokenEntity;
use Core\Auth\Domain\RefreshTokenId;

interface RefreshTokenRepositoryInterface
{
    public function create(RefreshTokenEntity $refreshToken): void;

    public function remove(RefreshTokenEntity $refreshToken): void;

    public function findById(RefreshTokenId $id): RefreshTokenEntity|null;
}
