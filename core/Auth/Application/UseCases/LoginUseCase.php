<?php

namespace Core\Auth\Application\UseCases;

use Core\Auth\Application\Dto\LoginInput;
use Core\Auth\Application\Dto\LoginOutput;
use Core\Auth\Domain\AccessToken;
use Core\Auth\Domain\RefreshTokenEntity;
use Core\Auth\Infra\DB\RefreshTokenRepositoryInterface;
use Core\Shared\Application\Exceptions\UnauthorizedException;
use Core\User\Domain\UserEntity;
use Core\User\Infra\DB\UserRepositoryInterface;

readonly class LoginUseCase
{
    private UserEntity $user;
    private RefreshTokenEntity $refreshToken;
    private AccessToken $accessToken;

    public function __construct(
        private UserRepositoryInterface $repository,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {
    }

    /**
     * @throws UnauthorizedException
     */
    public function execute(LoginInput $input): LoginOutput
    {
        $this->findUser($input);
        $this->validate($input);
        $this->createAccessToken();
        $this->createRefreshToken();

        return $this->output();
    }

    /**
     * @throws UnauthorizedException
     */
    private function findUser(LoginInput $input): void
    {
        $user = $this->repository->findByEmail($input->email);

        if (!$user) {
            throw new UnauthorizedException();
        }

        $this->user = $user;
    }

    /**
     * @throws UnauthorizedException
     */
    private function validate(LoginInput $input): void
    {
        if (!$this->user->checkPassword($input->password)) {
            throw new UnauthorizedException();
        }
    }

    private function createRefreshToken(): void
    {
        $refreshToken = RefreshTokenEntity::create([
            'user' => $this->user
        ]);

        $this->refreshTokenRepository->create($refreshToken);

        $this->refreshToken = $refreshToken;
    }

    private function createAccessToken(): void
    {
        $this->accessToken = AccessToken::create($this->user);
    }

    private function output(): LoginOutput
    {
        return new LoginOutput([
            'access_token' => $this->accessToken->value,
            'refresh_token' => $this->refreshToken->id->getValue(),
            'access_token_cookie' => $this->accessToken->cookie(),
            'refresh_token_cookie' => $this->refreshToken->cookie(),
        ]);
    }
}
