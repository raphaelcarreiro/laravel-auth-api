<?php

namespace Core\Session\Infra;

use Core\Session\Domain\SessionEntity;

interface SessionInterface
{
    public function get(): SessionEntity;
    public function save(SessionEntity $session): void;
}
