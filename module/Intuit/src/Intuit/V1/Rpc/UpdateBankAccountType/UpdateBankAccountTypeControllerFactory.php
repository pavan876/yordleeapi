<?php
namespace Intuit\V1\Rpc\UpdateBankAccountType;

class UpdateBankAccountTypeControllerFactory
{
    public function __invoke($controllers)
    {
        return new UpdateBankAccountTypeController();
    }
}
