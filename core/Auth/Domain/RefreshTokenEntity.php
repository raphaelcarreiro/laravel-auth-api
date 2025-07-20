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
    public readonly int $ttlInMinutes;

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

        $this->ttlInMinutes = config('refreshtoken.ttl');
    }

    public static function create(array $payload): RefreshTokenEntity
    {
        $expiresAt = time() + config('refreshtoken.ttl') * 60;

        return new self(
            id: new RefreshTokenId(),
            userId: $payload['user']->id,
            expiresAt: $expiresAt,
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
        return cookie(
            'refresh-token',
            $this->id->getValue(),
            $this->ttlInMinutes,
            "/",
            null,
            true,
            true,
            false,
            'None'
        );
    }
}
