<?php
namespace Intuit\V1\Rpc\FetchTransactionByAccount;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\Bank;
use Intuit\V1\Model\CustomerAccount;
use Intuit\V1\Model\CustomerTransaction;
use Intuit\V1\Model\IntuitInterface;


class FetchTransactionByAccountController extends AbstractActionController {

	private $customerTransaction;

    public function fetchTransactionByAccountAction() {
    	$customerId     = $this->getEvent()->getRouteMatch()->getParam('customer_id');
    	$accountId 		= $this->getEvent()->getRouteMatch()->getParam('account_id');
        $serviceLocator = $this->getServiceLocator();

        $account = new CustomerAccount( $serviceLocator );
        $this->customerTransaction = new CustomerTransaction( $this->serviceLocator );
        $accountInfo = $account->getAccountInfo( $customerId, $accountId );

        $result = new \stdClass;
        if( $accountInfo === false ) {
        	$result->result = 'error';
        	$result->message = "{$accountId} not found for {$customerId}";
        } else {
        	$this->updateAccountTransactions( $customerId, $accountInfo );
        	$result->result = 'success';
        	$result->transcations = $this->customerTransaction->getTransactions( $customerId, $accountId );
        }

        $response = $this->getResponse();
        $response->getHeaders()->addHeaders(array(
           	    'Content-Type' => 'application/json',
        ));
        return $response->setContent( json_encode( $result ) );
    }

    private function updateAccountTransactions( $customerId, $accountInfo ) {


        $lastDateInfo = $this->customerTransaction->getLastTransactionDate( $customerId, $accountInfo->accountId );

        if( $lastDateInfo === false ) {
        	$lastDate = $lastDateInfo->postedDate;
        } else {
    		$lastDate = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y') - 1 ) );
        }
    	$yesterday = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 1, date( 'Y') ) );

    	$bankAgencyId = Bank::getBankAgencyId();
    	$intuitInterface = new IntuitInterface( $this->serviceLocator );

    	$result = $intuitInterface->getAccountTransactions( $customerId, $accountInfo->accountId, $lastDate, $yesterday );
    	if( $result->result == 'success' ) {
    		$this->customerTransaction->persistCustomerTransactions( $customerId, $accountInfo->bankId, $bankAgencyId, $accountInfo->accountId, $result->data->bankingTransactions );
    	} 
    }
}
