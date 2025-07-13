<?php

namespace Core\Shared\Infra\DB;

use Core\Shared\Domain\Entity;
use Illuminate\Database\Eloquent\Model;

abstract class Mapper
{
    public abstract static function toEntity(Model $model): Entity;

    public abstract static function toModel(Entity $entity): Model;
}
