<?php
namespace Yodlee\V1\Rpc\AddSiteAccount;

class AddSiteAccountControllerFactory
{
    public function __invoke($controllers)
    {
        return new AddSiteAccountController();
    }
}
