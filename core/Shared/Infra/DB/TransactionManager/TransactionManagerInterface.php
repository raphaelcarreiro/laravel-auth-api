<?php

namespace Core\Shared\Infra\DB\TransactionManager;

interface TransactionManagerInterface
{
    public function withTransaction(callable $callback): mixed;
}
