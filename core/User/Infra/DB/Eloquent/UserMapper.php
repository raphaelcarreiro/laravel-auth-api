<?php

namespace Core\User\Infra\DB\Eloquent;

use Core\Shared\Domain\ValueObjects\Password;
use Core\User\Domain\UserEntity;
use Core\User\Domain\UserId;
use Core\User\Infra\DB\Eloquent\Models\UserModel;

class UserMapper
{
    public static function toEntity(UserModel $model): UserEntity
    {
        return new UserEntity(
            id: new UserId($model->id),
            name: $model->name,
            email: $model->email,
            password: new Password($model->password),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at,
        );
    }

    public static function toModel(UserEntity $entity): UserModel
    {
        return new UserModel($entity->toArray());
    }
}
