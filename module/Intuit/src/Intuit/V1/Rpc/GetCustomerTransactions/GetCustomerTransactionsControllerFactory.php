<?php
namespace Intuit\V1\Rpc\GetCustomerTransactions;

class GetCustomerTransactionsControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetCustomerTransactionsController();
    }
}
