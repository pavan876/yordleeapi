<?php
namespace Intuit\V1\Rpc\AddSiteAccount;

class AddSiteAccountControllerFactory
{
    public function __invoke($controllers)
    {
        return new AddSiteAccountController();
    }
}
