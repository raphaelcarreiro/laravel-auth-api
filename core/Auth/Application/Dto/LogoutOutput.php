<?php

namespace Core\Auth\Application\Dto;

use Core\Shared\Application\Dto\Dto;
use Symfony\Component\HttpFoundation\Cookie;

class LogoutOutput extends Dto
{
    public Cookie $refresh_token_cookie;
    public Cookie $access_token_cookie;
}
