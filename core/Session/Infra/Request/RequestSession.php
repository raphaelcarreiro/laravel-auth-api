<?php

namespace Core\Session\Infra\Request;

use Core\Auth\Domain\AccessToken;
use Core\Session\Domain\SessionEntity;
use Core\Session\Infra\SessionInterface;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Core\User\Domain\UserEntity;
use Exception;
use Illuminate\Support\Facades\Request;

class RequestSession implements SessionInterface
{
    /**
     * @throws UnauthorizedException
     */
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

    /**
     * @throws UnauthorizedException
     */
    private function getAccessTokenFromRequest(): AccessToken|null
    {
        $bearerToken = Request::cookie('access-token');

        if (!$bearerToken) {
            return null;
        }

        try {
            return AccessToken::createFrom($bearerToken);
        } catch (Exception $e) {
            throw new UnauthorizedException();
        }
    }
}
