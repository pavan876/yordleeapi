<?php
namespace Yodlee\V1\Rpc\GetBankList;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * All Banks list
 * Class GetBankListController
 * @package  Yodlee\V1\Rpc\GetBankList
 *
 * @author   Hari Dornala
 * @date     22 Dec 2014
 */
class GetBankListController extends AbstractActionController
{
    /**
     * Returns all banks list used for bank search auto suggest
     *
     * Function: getBankListAction
     * @author   Hari Dornala
     * @return array
     */
    public function getBankListAction()
    {
        $adapter   = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $sql       = "SELECT siteId, bankName FROM bank";
        $statement = $adapter->createStatement($sql, []);
        $result    = $statement->execute();
        $count     = $result->count();

        if ($count > 0) {
            $banks = [];

            foreach ($result as $item) {
                $banks[] = $item;
            }

            return [
                "count" => $count,
                "banks" => $banks
            ];
        } else {
            return [
                "count" => 0,
                "banks" => []
            ];
        }
    }
}
