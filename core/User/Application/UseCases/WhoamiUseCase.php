<?php

namespace Core\User\Application\UseCases;

use Core\Session\Infra\SessionTrait;
use Core\User\Application\Dto\UserOutput;
use Core\User\Infra\DB\UserRepositoryInterface;

class WhoamiUseCase
{
    use SessionTrait;
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function execute(): UserOutput
    {
        $session = $this->session()->get();

        return new UserOutput($session->user->toArray());
    }
}
