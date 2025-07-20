<?php

namespace Core\Auth\Domain;

use Core\Shared\Domain\Exceptions\DomainException;
use Core\User\Domain\UserEntity;
use Core\User\Domain\UserId;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Symfony\Component\HttpFoundation\Cookie;

class AccessToken
{
    public string $value;
    public int $expiresAt;
    private string $secret;
    public readonly int $ttlInMinutes;
    public readonly UserId $subject;
    private const ALGORITHM = 'HS256';

    private function __construct(
        string $issuer,
        string $audience,
        int $issuedAt,
        int $expiresAt,
        string $subject
    ) {
        $this->secret = config('jwt.secret');
        $this->ttlInMinutes = config('jwt.ttl');

        $this->encode([
            'iss' => $issuer,
            'aud' => $audience,
            'iat' => $issuedAt,
            'exp' => $expiresAt,
            'sub' => $subject,
        ]);
    }

    private function encode(array $payload): void
    {
        $expiresAtInSeconds = time() + $this->ttlInMinutes * 60;

        $this->value = JWT::encode($payload, $this->secret, self::ALGORITHM);
        $this->expiresAt = $expiresAtInSeconds;
        $this->subject = new UserId($payload['sub']);
    }

    public static function create(UserEntity $user): self
    {
        $expiresAtInSeconds = time() + config('jwt.ttl') * 60;

        return new self(
            issuer: 'https://api.example.com',
            audience: 'https://front.example.com',
            issuedAt: time(),
            expiresAt: $expiresAtInSeconds,
            subject: $user->id->getValue()
        );
    }

    public static function createFrom(string $value): self
    {
        $payload = self::decode($value);

        return new self(
            issuer: $payload['iss'],
            audience: $payload['aud'],
            issuedAt: $payload['iat'],
            expiresAt: $payload['exp'],
            subject: $payload['sub']
        );
    }

    /**
     * @throws DomainException
     */
    private static function decode(string $value): array
    {
        $secret = config('jwt.secret');

        try {
            return (array) JWT::decode($value, new Key($secret, 'HS256'));
        } catch (Exception $exception) {
            throw new DomainException('invalid access token', 401);
        }
    }

    public function cookie(): Cookie
    {
        return cookie(
            'access-token',
            $this->value,
            $this->ttlInMinutes,
            "/",
            null,
            true,
            true,
            false,
            'None'
        );
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->value,
            'expires_at' => $this->expiresAt,
        ];
    }
}
