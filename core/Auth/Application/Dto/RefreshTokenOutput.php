<?php

namespace Core\Auth\Application\Dto;

use Core\Shared\Application\Dto\Dto;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenOutput extends Dto
{
    public string $access_token;
    public string $refresh_token;
    public Cookie $access_token_cookie;
    public Cookie $refresh_token_cookie;
}
