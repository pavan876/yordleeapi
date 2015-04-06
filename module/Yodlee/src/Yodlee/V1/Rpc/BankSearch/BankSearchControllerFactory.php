<?php
namespace Yodlee\V1\Rpc\BankSearch;

class BankSearchControllerFactory
{
    public function __invoke($controllers)
    {
        return new BankSearchController();
    }
}
