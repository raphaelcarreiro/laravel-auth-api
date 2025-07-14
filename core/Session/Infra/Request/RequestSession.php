<?php

namespace Core\Session\Infra\Request;

use Core\Auth\Domain\AccessToken;
use Core\Session\Domain\SessionEntity;
use Core\Session\Infra\SessionInterface;
use Core\User\Domain\UserEntity;
use Illuminate\Support\Facades\Request;

class RequestSession implements SessionInterface
{
    public function get(): SessionEntity
    {
        $accessToken = $this->getAccessTokenFromRequest();
        $user = $this->getUserFromRequest();

        return SessionEntity::create([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }

    public function save(SessionEntity $session): void
    {
        // TODO: Implement save() method.
    }

    private function getUserFromRequest(): UserEntity|null
    {
        $payload = Request::get('user');

        if (!$payload) {
            return null;
        }

        return UserEntity::fromArray($payload);
    }

    private function getAccessTokenFromRequest(): AccessToken|null
    {
        $bearerToken = Request::cookie('access-token');

        if (!$bearerToken) {
            return null;
        }

        return AccessToken::createFrom($bearerToken);
    }
}
