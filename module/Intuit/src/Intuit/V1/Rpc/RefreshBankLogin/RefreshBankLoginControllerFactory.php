<?php
namespace Intuit\V1\Rpc\RefreshBankLogin;

class RefreshBankLoginControllerFactory
{
    public function __invoke($controllers)
    {
        return new RefreshBankLoginController();
    }
}
