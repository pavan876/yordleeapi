<?php
namespace Intuit\V1\Rpc\FetchTransactionByAccount;

class FetchTransactionByAccountControllerFactory
{
    public function __invoke($controllers)
    {
        return new FetchTransactionByAccountController();
    }
}
