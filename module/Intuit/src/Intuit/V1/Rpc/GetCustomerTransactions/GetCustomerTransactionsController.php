<?php
namespace Intuit\V1\Rpc\GetCustomerTransactions;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\CustomerTransaction;

class GetCustomerTransactionsController extends AbstractActionController {

    public function getCustomerTransactionsAction() {

        $customerId     = $this->getEvent()->getRouteMatch()->getParam('customer_id');
        $page             = $this->getRequest()->getQuery('page');
        $limit            = $this->getRequest()->getQuery('limit');
        $serviceLocator = $this->getServiceLocator();

        $start = 0;
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
        } else {
        	$limit = 50;
        }

        $customerXaction = new CustomerTransaction( $serviceLocator );
        $result = $customerXaction->getTransactions( $customerId, null, null, null, $start, $limit );

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array(
           	    'Content-Type' => 'application/json',
        ));
        return $response->setContent( json_encode( $result ) );
    }
}
