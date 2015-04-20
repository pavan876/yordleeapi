<?php
namespace Intuit\V1\Rpc\GetCustomerTransactions;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\CustomerTransaction;

class GetCustomerTransactionsController extends AbstractActionController {

    public function getCustomerTransactionsAction() {

        $customerId     = $this->getEvent()->getRouteMatch()->getParam( 'customerId', null );
        $accountId      = $this->getEvent()->getRouteMatch()->getParam( 'accountId', null );
        $limit            = $this->getRequest()->getQuery( 'limit', 50 );
        $page            = $this->getRequest()->getQuery( 'page', 1 );
        $serviceLocator = $this->getServiceLocator();

        $start = 0;
        if (isset($limit) && is_numeric($limit)) {
            $limit = (int) $limit;
        } else {
            $limit = 50;
        }

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

        $customerXaction = new CustomerTransaction( $serviceLocator );
        $result = new \stdClass;
        $result->result = 'success';
        $result->transactions = $customerXaction->getTransactions( $customerId, $accountId, null, null, $start, $limit );

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array(
           	    'Content-Type' => 'application/json',
        ));
        return $response->setContent( json_encode( $result ) );
    }
}
