<?php
namespace Intuit\V1\Rpc\RefreshBankList;

class RefreshBankListControllerFactory
{
    public function __invoke($controllers)
    {
        return new RefreshBankListController();
    }
}
