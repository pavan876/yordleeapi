<?php
namespace Intuit\V1\Rpc\RemoveCustomer;

class RemoveCustomerControllerFactory
{
    public function __invoke($controllers)
    {
        return new RemoveCustomerController();
    }
}
