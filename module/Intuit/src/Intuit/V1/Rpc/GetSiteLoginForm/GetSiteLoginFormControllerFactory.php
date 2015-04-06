<?php
namespace Intuit\V1\Rpc\GetSiteLoginForm;

class GetSiteLoginFormControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetSiteLoginFormController();
    }
}
