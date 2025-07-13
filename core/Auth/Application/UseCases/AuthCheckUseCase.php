<?php

namespace Core\Auth\Application\UseCases;

use Core\Auth\Domain\AccessToken;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Core\Shared\Domain\Exceptions\DomainException;
use Core\User\Domain\UserEntity;
use Core\User\Infra\DB\UserRepositoryInterface;

readonly class AuthCheckUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws UnauthorizedException
     */
    public function execute(string|null $bearerToken): UserEntity
    {
        $this->validate($bearerToken);
        $accessToken = $this->initializeAccessToken($bearerToken);
        return $this->findUser($accessToken);
    }

    /**
     * @throws UnauthorizedException
     */
    private function initializeAccessToken(string|null $bearerToken): AccessToken
    {
        try {
            return AccessToken::createFrom($bearerToken);
        } catch (DomainException $e) {
            throw new UnauthorizedException();
        }
    }

    /**
     * @throws UnauthorizedException
     */
    public function validate(string|null $accessToken): void
    {
        if (!$accessToken) {
            throw new UnauthorizedException();
        }
    }

    /**
     * @throws UnauthorizedException
     */
    private function findUser(AccessToken $accessToken): UserEntity
    {
        $user = $this->repository->findById($accessToken->subject);

        if (!$user) {
            throw new UnauthorizedException();
        }

        return $user;
    }
}
