<?php
namespace Yodlee\V1\Rpc\GetBankList;

class GetBankListControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetBankListController();
    }
}
