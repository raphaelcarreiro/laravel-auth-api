<?php

namespace Core\Auth\Application\Dto;

use Core\Shared\Application\Dto\Dto;

class LoginInput extends Dto
{
    public string $email;
    public string $password;
}
