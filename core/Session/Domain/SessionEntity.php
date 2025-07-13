<?php

namespace Core\Session\Domain;

use Core\Auth\Domain\AccessToken;
use Core\Shared\Domain\Entity;
use Core\User\Domain\UserEntity;

class SessionEntity extends Entity
{
    public function __construct(public readonly UserEntity $user, public readonly AccessToken $accessToken)
    {
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user->toArray(),
            'access_token' => $this->accessToken->toArray(),
        ];
    }

    public static function create(array $payload): self
    {
        return new self(
            user: $payload['user'],
            accessToken: $payload['access_token']
        );
    }
}
