<?php
namespace Intuit\V1\Rpc\MFARequestForRefresh;

class MFARequestForRefreshControllerFactory
{
    public function __invoke($controllers)
    {
        return new MFARequestForRefreshController();
    }
}
