<?php
namespace Intuit\V1\Rpc\MFARequestForSite;

class MFARequestForSiteControllerFactory
{
    public function __invoke($controllers)
    {
        return new MFARequestForSiteController();
    }
}
