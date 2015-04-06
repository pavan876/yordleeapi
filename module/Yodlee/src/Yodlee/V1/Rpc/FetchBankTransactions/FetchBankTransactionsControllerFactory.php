<?php
namespace Yodlee\V1\Rpc\FetchBankTransactions;

class FetchBankTransactionsControllerFactory
{
    public function __invoke($controllers)
    {
        return new FetchBankTransactionsController();
    }
}
