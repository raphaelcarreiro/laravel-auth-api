<?php

namespace Core\Auth\Infra\DB\Eloquent\Models;

use Core\Auth\Domain\RefreshTokenEntity;
use Core\Auth\Domain\RefreshTokenId;
use Core\User\Domain\UserId;

class RefreshTokenMapper
{
    public static function toEntity(RefreshTokenModel $model): RefreshTokenEntity
    {
        return new RefreshTokenEntity(
            id: new RefreshTokenId($model->id),
            userId: new UserId($model->user_id),
            expiresAt: $model->expires_at,
            createdAt: $model->created_at,
        );
    }

    public static function toModel(RefreshTokenEntity $entity): RefreshTokenModel
    {
        return new RefreshTokenModel($entity->toArray());
    }
}
