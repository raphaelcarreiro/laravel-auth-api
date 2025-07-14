<?php

namespace Core\Shared\Infra\DB\Eloquent;

use Core\Shared\Infra\DB\TransactionManagerInterface;

trait TransactionManagerTrait
{
    public function transactionManager(): TransactionManagerInterface
    {
        return new TransactionManager();
    }
}
