<?php
namespace Intuit\V1\Rpc\RefreshAccountLogin;

class RefreshAccountLoginControllerFactory
{
    public function __invoke($controllers)
    {
        return new RefreshAccountLoginController();
    }
}
