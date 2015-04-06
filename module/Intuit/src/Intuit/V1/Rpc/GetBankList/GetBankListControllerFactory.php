<?php
namespace Intuit\V1\Rpc\GetBankList;

class GetBankListControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetBankListController();
    }
}
