<?php

namespace Core\User\Domain;

use Core\Shared\Domain\Entity;
use Core\Shared\Domain\Traits\TimestampsTrait;
use Core\Shared\Domain\ValueObjects\Password;
use DateTime;
use DateTimeInterface;

class UserEntity extends Entity
{
    use TimestampsTrait;

    public readonly UserId $id;
    private string $name;
    private string $email;
    private Password $password;

    public function __construct(
        UserId $id,
        string $name,
        string $email,
        Password $password,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(array $payload): self
    {
        return new self(
            id: new UserId(),
            name: $payload['name'],
            email: $payload['email'],
            password: new Password($payload['password']),
            createdAt: new DateTime(),
            updatedAt: new DateTime()
        );
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            id: new UserId($payload['id']),
            name: $payload['name'],
            email: $payload['email'],
            password: new Password($payload['password']),
            createdAt: new DateTime($payload['created_at']),
            updatedAt: new DateTime($payload['updated_at']),
        );
    }
    public function changeName(string $name): self
    {
        $this->updatedAt = new DateTime();
        $this->name = $name;
        return $this;
    }

    public function changePassword(Password $password): self
    {
        $this->updatedAt = new DateTime();
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function checkPassword(string $value): bool
    {
        return $this->password->check($value);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password->getValue(),
            'created_at' => $this->createdAtIsoString(),
            'updated_at' => $this->updatedAtIsoString(),
        ];
    }
}
