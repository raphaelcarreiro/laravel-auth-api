<?php

namespace Core\Shared\Infra\DB;

interface TransactionManagerInterface
{
    public function withTransaction(callable $callback): mixed;
}
