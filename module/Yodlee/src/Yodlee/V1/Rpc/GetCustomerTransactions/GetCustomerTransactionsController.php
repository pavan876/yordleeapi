<?php
namespace Yodlee\V1\Rpc\GetCustomerTransactions;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\TableGateway\TableGateway;
use ZF\Rest\Exception\RuntimeException;

/**
 * Class GetCustomerTransactionsController
 *
 * @package Yodlee\V1\Rpc\GetCustomerTransactions
 * @author  Hari Dornala
 * @date    3 Jul 2014
 */
class GetCustomerTransactionsController extends AbstractActionController
{
    public function getCustomerTransactionsAction()
    {
        $this->customerId = $this->getEvent()->getRouteMatch()->getParam('customer_id');
        $page             = $this->getRequest()->getQuery('page');
        $limit            = $this->getRequest()->getQuery('limit');

        $bankAgency   = new BankAgency($this->getServiceLocator(), $this->customerId);
        $this->yodlee = new YodleeBroker($this->getServiceLocator(), $bankAgency);

        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');

        $sql = "SELECT a.siteId, a.memSiteAccId,b.containerName,c.itemAccountId, d.*
                FROM customer_bank a
                JOIN customer_bank_item b ON a.memSiteAccId=b.memSiteAccId
                JOIN customer_bank_item_account c ON b.itemId=c.itemId
                JOIN customer_bank_transaction d ON c.itemAccountId=d.itemAccountId
                WHERE a.customerId=?
                ORDER BY d.postDate DESC";

        if (isset($limit) && is_numeric($limit)) {
            $limit = (int) $limit;
            if (isset($page) && is_numeric($page)) {
                $page = (int) $page;
                if ($page == 1) {
                    $page = 0;
                } else {
                    $page--;
                }

                $start = $page * $limit;
            } else {
                $start = 0;
            }
            $sql .=  " LIMIT {$start}, {$limit}";
        } else {
            $sql .= " LIMIT 0, 50";
        }

        $statement = $adapter->createStatement($sql, array($this->customerId));
        $result    = $statement->execute();
        $count     = $result->count();

        if ($count > 0) {
            $transactions = array();
            foreach ($result as $transaction) {
                $transactions[] = $transaction;
            }

            return array(
                "total"    => $count,
                "accounts" => $transactions
            );
        }

        return array(
            "message" => "no transactions found"
        );
    }
}
