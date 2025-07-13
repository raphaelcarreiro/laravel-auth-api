<?php

namespace Core\User\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class CreateUserInput extends Dto
{
    public string $name;
    public string $email;
    public string $password;
}
