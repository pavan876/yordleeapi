<?php
namespace Yodlee\V1\Rpc\MFARequestForSite;

class MFARequestForSiteControllerFactory
{
    public function __invoke($controllers)
    {
        return new MFARequestForSiteController();
    }
}
