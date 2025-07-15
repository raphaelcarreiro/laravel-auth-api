<?php

namespace Core\Auth\Application\UseCases;

use Core\Auth\Application\Dto\RefreshTokenOutput;
use Core\Auth\Domain\AccessToken;
use Core\Auth\Domain\RefreshTokenEntity;
use Core\Auth\Domain\RefreshTokenId;
use Core\Auth\Infra\DB\RefreshTokenRepositoryInterface;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Core\Shared\Infra\DB\TransactionManagerTrait;
use Core\User\Domain\UserEntity;
use Core\User\Infra\DB\UserRepositoryInterface;

readonly class RefreshTokenUseCase
{
    use TransactionManagerTrait;

    public function __construct(
        private RefreshTokenRepositoryInterface $repository,
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws UnauthorizedException
     */
    public function execute(string|null $refreshTokenId): RefreshTokenOutput
    {
        $currentRefreshToken = $this->findRefreshToken($refreshTokenId);

        $user = $this->findUser($currentRefreshToken);

        $newRefreshToken = $this->createRefreshToken($currentRefreshToken, $user);

        $accessToken = AccessToken::create($user);

        return $this->output($accessToken, $newRefreshToken);
    }

    /**
     * @throws UnauthorizedException
     */
    private function findRefreshToken(string|null $refreshTokenId): RefreshTokenEntity
    {
        if (!$refreshTokenId) {
            throw new UnauthorizedException();
        }

        $refreshToken = $this->repository->findById(new RefreshtokenId($refreshTokenId));

        if (!$refreshToken) {
            throw new UnauthorizedException();
        }

        return $refreshToken;
    }

    /**
     * @throws UnauthorizedException
     */
    private function findUser(RefreshTokenEntity $refreshToken): UserEntity
    {
        $user = $this->userRepository->findById($refreshToken->userId);

        if (!$user) {
            throw new UnauthorizedException();
        }

        return $user;
    }

    private function createRefreshToken(RefreshTokenEntity $refreshToken, UserEntity $user): RefreshTokenEntity
    {
        return $this->transactionManager()->withTransaction(function () use ($refreshToken, $user) {
            return $this->handleTransaction($refreshToken, $user);
        });
    }

    private function handleTransaction(RefreshTokenEntity $refreshToken, UserEntity $user): RefreshTokenEntity
    {
        $this->repository->remove($refreshToken);

        $newRefreshToken = RefreshTokenEntity::create(['user' => $user]);
        $this->repository->create($newRefreshToken);

        return $newRefreshToken;
    }

    private function output(AccessToken $accessToken, RefreshTokenEntity $refreshToken): RefreshTokenOutput
    {
        return new RefreshTokenOutput([
            'access_token' => $accessToken->value,
            'refresh_token' => $refreshToken->id->getValue(),
            'access_token_cookie' => $accessToken->cookie(),
            'refresh_token_cookie' => $refreshToken->cookie(),
        ]);
    }
}
