<?php

namespace Core\User\Infra\DB\Eloquent;

use Core\Shared\Application\Exceptions\NotFoundException;
use Core\User\Domain\UserEntity;
use Core\User\Domain\UserId;
use Core\User\Infra\DB\Eloquent\Models\UserModel;
use Core\User\Infra\DB\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function create(UserEntity $entity): void
    {
        $model = UserMapper::toModel($entity);
        $model->save();
    }

    /**
     * @throws NotFoundException
     */
    public function findById(UserId $id, $options = ['throwNotFound' => true]): UserEntity|null
    {
        $model = UserModel::query()->find($id->getValue());

        if (!$model && $options['throwNotFound']) {
            throw new NotFoundException("user id:{$id->getValue()} was not found");
        }

        if (!$model) {
            return null;
        }

        return UserMapper::toEntity($model);
    }

    public function findByEmail(string $email): UserEntity|null
    {
        $model = UserModel::query()->where('email', '=', $email)->first();

        if (!$model) {
            return null;
        }

        return UserMapper::toEntity($model);
    }
}
