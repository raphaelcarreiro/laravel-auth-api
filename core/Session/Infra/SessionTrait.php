<?php

namespace Core\Session\Infra;

use Core\Session\Infra\Request\RequestSession;

trait SessionTrait
{
    public function session(): SessionInterface
    {
        return new RequestSession();
    }
}
