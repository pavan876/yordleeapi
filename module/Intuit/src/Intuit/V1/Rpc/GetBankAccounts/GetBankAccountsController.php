<?php
namespace Intuit\V1\Rpc\GetBankAccounts;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\CustomerAccount;

class GetBankAccountsController extends AbstractActionController {

    public function getBankAccountsAction() {

        $customerId     = $this->getEvent()->getRouteMatch()->getParam('customerId');
        $serviceLocator = $this->getServiceLocator();

        $customerAccount = new CustomerAccount( $serviceLocator );
        $result = $customerAccount->getAccounts( $customerId );

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array(
           	    'Content-Type' => 'application/json',
        ));
        return $response->setContent( json_encode( $result ) );
    }
}
