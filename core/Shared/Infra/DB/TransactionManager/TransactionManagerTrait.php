<?php

namespace Core\Shared\Infra\DB\TransactionManager;

use Core\Shared\Infra\DB\TransactionManager\Eloquent\TransactionManager;

trait TransactionManagerTrait
{
    public function transactionManager(): TransactionManagerInterface
    {
        return new TransactionManager();
    }
}
