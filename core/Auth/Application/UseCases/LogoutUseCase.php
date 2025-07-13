<?php

namespace Core\Auth\Application\UseCases;

use Core\Auth\Application\Dto\LogoutOutput;
use Symfony\Component\HttpFoundation\Cookie;

readonly class LogoutUseCase
{
    public function __construct()
    {
    }

    public function execute(): LogoutOutput
    {
        return new LogoutOutput([
            'access_token_cookie' => $this->deleteAccessToken(),
            'refresh_token_cookie' => $this->deleteRefreshToken(),
        ]);
    }

    private function deleteAccessToken(): Cookie
    {
        return cookie(
            "access-token",
            'deleted',
            -2628000,
            "/",
            null,
            true,
            true,
            false,
            'None'
        );
    }

    private function deleteRefreshToken(): Cookie
    {
        return cookie(
            "refresh-token",
            'deleted',
            -2628000,
            "/",
            null,
            true,
            true,
            false,
            'None'
        );
    }
}
