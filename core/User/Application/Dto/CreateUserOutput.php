<?php

namespace Core\User\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class CreateUserOutput extends Dto
{
    public string $id;
    public string $name;
    public string $email;
    public string $created_at;
}
