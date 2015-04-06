<?php
namespace Intuit\V1\Rpc\AddSiteAccount;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use Intuit\V1\Model\IntuitInterface;
use Intuit\V1\Model\Bank;
use Intuit\V1\Model\CustomerAccount;
use Intuit\V1\Model\CustomerTransaction;

class AddSiteAccountController extends AbstractActionController
{
	private $intuitInterface;

    public function addSiteAccountAction() {
    	$request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

            $intuitResult = $this->processIntuitRequest( $data );

			$response = $this->getResponse();
			$response->getHeaders()->addHeaders(array(
			           'Content-Type' => 'application/json',
			));

    		switch( $intuitResult->result ) {

    			case 'success':
		    			$result = new \stdClass;
			    		$result->result = 'success';

			    		$bankingAccounts = [];
			    		foreach( $intuitResult->data->accounts as $account ) {
			    			if( $account->type == 'bankingAccount' )
			    				$bankingAccounts[] = $account;
			    		}

		    			$account = new CustomerAccount( $this->getServiceLocator() );
		    			$result->message = $account->persistCustomerAccounts( $data->customer_id, $bankingAccounts );
		    			$transactionResults = $this->addAccountTransactions( $data->customer_id, $bankingAccounts );

		    			$result->message = $result->message . "\n" . implode( "\n", $transactionResults );

		    			$intuitInterface = null;
			            return $response->setContent( json_encode( $result ) );
			            break;
			    case 'challenge':
			            return $response->setContent( json_encode( $intuitResult ) );
			            break;
			    default: 
	            	if( $intuitResult->error == null ) {
		    			$intuitInterface = null;
	            		return new ApiProblem( 500, 'Unknown error' );
	            	}
	            	else {
		    			$intuitInterface = null;
	            		return new ApiProblem( 500, json_encode( $intuitResult->error ) );
	            	}
	            	break;
            }

        } else {
	    	$intuitInterface = null;
            return new ApiProblem(405, 'Method not allowed');
        }
        
    }

    protected function processIntuitRequest( $data ) {

    	    $this->intuitInterface = new IntuitInterface( );
    		$intuitResult = $this->intuitInterface->discoverAndAddAccounts( $data->customer_id, $data->bank_id, $data->login_parameters );

    		return $intuitResult;
    }

    private function addAccountTransactions( $customerId, $accounts ) {

    	$bankAgencyId = Bank::getBankAgencyId();
    	$yesteryear = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y') - 1 ) );
    	$yesterday = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 1, date( 'Y') ) );

    	$xaction = new CustomerTransaction( $this->getServiceLocator() );
    	$results = [];
    	foreach( $accounts as $account ) {
    		$result = $this->intuitInterface->getAccountTransactions( $customerId, $account->accountId, $yesteryear, $yesterday );
    		if( $result->result == 'success' ) {
    			$results[] = $xaction->persistCustomerTransactions( $customerId, $account->institutionId, $bankAgencyId, $account->accountId, $result->data->bankingTransactions );
    		} else {
    			$error = ($result->error == null)?('Unknown error'):(json_encode($result->error));
    			$results[] = "Error encountered when retrieving transactiosn for {$account->accountNumber}: {$error}";
    		}
    	}

    	return $results;
    }
}
