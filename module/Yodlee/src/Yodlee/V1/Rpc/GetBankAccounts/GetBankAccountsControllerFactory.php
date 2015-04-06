<?php
namespace Yodlee\V1\Rpc\GetBankAccounts;

class GetBankAccountsControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetBankAccountsController();
    }
}
