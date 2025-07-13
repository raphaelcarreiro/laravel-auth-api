<?php

namespace Core\Auth\Domain;

use Core\Shared\Domain\Entity;
use Core\User\Domain\UserId;
use DateTime;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenEntity extends Entity
{
    public readonly RefreshTokenId $id;
    public readonly UserId $userId;
    public readonly int $expiresAt;
    public readonly Datetime $createdAt;
    private readonly int $ttl;

    public function __construct(
        RefreshTokenId $id,
        UserId $userId,
        int $expiresAt,
        DateTime $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->expiresAt = $expiresAt;
        $this->createdAt = $createdAt;
    }

    public static function create(array $payload): RefreshTokenEntity
    {
        $ttl = (int) config('refreshtoken.ttl');

        return new self(
            id: new RefreshTokenId(),
            userId: $payload['user']->id,
            expiresAt: time() + $ttl,
            createdAt: new DateTime()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'user_id' => $this->userId->getValue(),
            'expires_at' => $this->expiresAt,
            'created_at' => $this->createdAt,
        ];
    }

    public function cookie(): Cookie
    {
        $ttl = (int) config('refreshtoken.ttl');

        return cookie(
            'refresh-token',
            $this->id->getValue(),
            $ttl,
            "/",
            null,
            true,
            true,
            false,
            'None'
        );
    }
}
