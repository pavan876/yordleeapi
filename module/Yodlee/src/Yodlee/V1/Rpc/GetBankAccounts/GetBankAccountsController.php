<?php
namespace Yodlee\V1\Rpc\GetBankAccounts;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\TableGateway\TableGateway;
use ZF\Rest\Exception\RuntimeException;

/**
 * Class GetBankAccountsController
 *
 * @package Yodlee\V1\Rpc\GetBankAccounts
 * @author  Hari Dornala
 * @date    3 Jul 2014
 */
class GetBankAccountsController extends AbstractActionController
{
    private $customerId;

    public function getBankAccountsAction()
    {
        $this->customerId = $this->getEvent()->getRouteMatch()->getParam('customer_id');
        $bankAgency       = new BankAgency($this->getServiceLocator(), $this->customerId);
        $this->yodlee     = new YodleeBroker($this->getServiceLocator(), $bankAgency);

        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');

        $sql = "SELECT a.siteId, a.memSiteAccId,b.containerName,b.itemDisplayName,c.*
                FROM customer_bank a
                JOIN customer_bank_item b ON a.memSiteAccId=b.memSiteAccId
                JOIN customer_bank_item_account c ON b.itemId=c.itemId
                WHERE a.customerId=?";

        $statement = $adapter->createStatement($sql, array($this->customerId));
        $result    = $statement->execute();
        $count     = $result->count();

        if ($count > 0) {
            $accounts = array();
            foreach ($result as $account) {
                $accounts[] = $account;
            }

            return array(
                "result"   => "success",
                "total"    => $count,
                "accounts" => $accounts
            );
        }

        return array(
            'message' => 'No accounts found'
        );
    }
}
