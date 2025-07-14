<?php

namespace Core\Shared\Infra\Logger;

use Core\Shared\Infra\Logger\Laravel\Logger;

trait LoggerTrait
{
    public function logger(): LoggerInterface
    {
        return new Logger();
    }
}
