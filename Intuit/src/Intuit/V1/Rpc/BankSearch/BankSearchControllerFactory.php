<?php
namespace Intuit\V1\Rpc\BankSearch;

class BankSearchControllerFactory
{
    public function __invoke($controllers)
    {
        return new BankSearchController();
    }
}
