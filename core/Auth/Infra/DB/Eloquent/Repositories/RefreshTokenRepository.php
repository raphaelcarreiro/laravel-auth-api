<?php

namespace Core\Auth\Infra\DB\Eloquent\Repositories;

use Core\Auth\Domain\RefreshTokenEntity;
use Core\Auth\Domain\RefreshTokenId;
use Core\Auth\Infra\DB\Eloquent\Models\RefreshTokenMapper;
use Core\Auth\Infra\DB\Eloquent\Models\RefreshTokenModel;
use Core\Auth\Infra\DB\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function create(RefreshTokenEntity $refreshToken): void
    {
        $model = RefreshTokenMapper::toModel($refreshToken);
        $model->save();
    }

    public function remove(RefreshTokenEntity $refreshToken): void
    {
        $model = RefreshtokenModel::query()->find($refreshToken->id);
        $model->delete();
    }

    public function findById(RefreshTokenId $id): RefreshTokenEntity|null
    {
        $token = RefreshTokenModel::query()->find($id);

        if (!$token) {
            return null;
        }

        return RefreshTokenMapper::toEntity($token);
    }
}
