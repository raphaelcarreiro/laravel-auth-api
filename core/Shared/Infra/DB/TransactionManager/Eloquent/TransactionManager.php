<?php

namespace Core\Shared\Infra\DB\TransactionManager\Eloquent;

use Core\Shared\Infra\DB\TransactionManager\TransactionManagerInterface;
use Illuminate\Support\Facades\DB;

class TransactionManager implements TransactionManagerInterface
{
    public function withTransaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
