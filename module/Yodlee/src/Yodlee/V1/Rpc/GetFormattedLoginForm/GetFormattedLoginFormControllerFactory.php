<?php
namespace Yodlee\V1\Rpc\GetFormattedLoginForm;

class GetFormattedLoginFormControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetFormattedLoginFormController();
    }
}
