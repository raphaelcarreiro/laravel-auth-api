<?php

namespace Core\Auth\Infra\DB\Eloquent\Repositories;

use Core\Auth\Domain\RefreshTokenEntity;
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
}
