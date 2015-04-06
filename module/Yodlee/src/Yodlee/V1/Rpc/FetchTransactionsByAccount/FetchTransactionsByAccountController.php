<?php
namespace Yodlee\V1\Rpc\FetchTransactionsByAccount;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\Transactions;
use Analytics\V1\Model\CustomerSpendingAnalytics;

use Zend\Db\TableGateway\TableGateway;

class FetchTransactionsByAccountController extends AbstractActionController
{
    public function fetchTransactionsByAccountAction()
    {
        $accountId      = $this->getEvent()->getRouteMatch()->getParam('mem_site_account_id');
        $serviceLocator = $this->getServiceLocator();

        $transactions = new Transactions($serviceLocator);
        $result       = $transactions->processByMemSiteAccId($accountId);
        $customerId   = $transactions->getCustomerId();

        if ($customerId) {
            $spendingAnalytics = new CustomerSpendingAnalytics($serviceLocator, $customerId);
        }

        return $result;
        exit;
    }


}
