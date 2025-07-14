<?php

namespace Core\Session\Domain;

use Core\Auth\Domain\AccessToken;
use Core\Shared\Domain\Entity;
use Core\User\Domain\UserEntity;

class SessionEntity extends Entity
{
    public function __construct(public readonly UserEntity|null $user, public readonly AccessToken|null $accessToken)
    {
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user?->toArray() ?? null,
            'access_token' => $this->accessToken?->toArray() ?? null,
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
