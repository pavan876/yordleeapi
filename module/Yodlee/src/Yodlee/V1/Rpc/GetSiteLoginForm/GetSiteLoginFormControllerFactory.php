<?php
namespace Yodlee\V1\Rpc\GetSiteLoginForm;

class GetSiteLoginFormControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetSiteLoginFormController();
    }
}
