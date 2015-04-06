<?php
namespace Intuit\V1\Rpc\GetBankAccounts;

class GetBankAccountsControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetBankAccountsController();
    }
}
