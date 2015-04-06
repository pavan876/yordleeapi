<?php
namespace Yodlee\V1\Rpc\FetchTransactionsByAccount;

class FetchTransactionsByAccountControllerFactory
{
    public function __invoke($controllers)
    {
        return new FetchTransactionsByAccountController();
    }
}
