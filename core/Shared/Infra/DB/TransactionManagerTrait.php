<?php

namespace Core\Shared\Infra\DB;

use Core\Shared\Infra\DB\Eloquent\TransactionManager;

trait TransactionManagerTrait
{
    public function transactionManager(): TransactionManagerInterface
    {
        return new TransactionManager();
    }
}
