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
                        $accounts = $intuitResult->data->accounts;

		    			$account = new CustomerAccount( $this->getServiceLocator() );
		    			$result->accounts = $account->persistCustomerAccounts( $data->customerId, $accounts );
		    			$result->transactions = $this->addAccountTransactions( $data->customerId, $accounts );

			            return $response->setContent( json_encode( $result ) );
			            break;
			    case 'challenge':
			            return $response->setContent( json_encode( $intuitResult ) );
			            break;
			    default: 
	            	if( $intuitResult->error == null ) {
	            		return new ApiProblem( 500, 'Unknown error' );
	            	}
	            	else {
	            		return new ApiProblem( 500, json_encode( $intuitResult->error ) );
	            	}
	            	break;
            }

        } else {
            return new ApiProblem(405, 'Method not allowed');
        }
        
    }

    protected function processIntuitRequest( $data ) {

    	    $intuitInterface = new IntuitInterface( );
    		$intuitResult = $intuitInterface->discoverAndAddAccounts( $data->customerId, $data->bankId, $data->loginParameters );

    		return $intuitResult;
    }

    private function addAccountTransactions( $customerId, $accounts ) {

    	$bankAgencyId = Bank::getBankAgencyId();
    	$yesteryear = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y') - 1 ) );
    	$yesterday = date( 'Y-m-d', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 1, date( 'Y') ) );

        $intuitInterface = new IntuitInterface( );
    	$xaction = new CustomerTransaction( $this->getServiceLocator() );
    	$errors = [];
        $xactionsAdded = 0;
    	foreach( $accounts as $account ) {
    		$result = $intuitInterface->getAccountTransactions( $customerId, $account->accountId, $yesteryear, $yesterday );
    		if( $result->result == 'success' ) {
                if( isset( $result->data->bankingTransactions ) )
    			    $xactionsAdded += $xaction->persistCustomerTransactions( $customerId, $account->institutionId, $bankAgencyId, $account->accountId, $result->data->bankingTransactions );
                if( isset( $result->data->creditCardTransactions ) )
                    $xactionsAdded += $xaction->persistCustomerTransactions( $customerId, $account->institutionId, $bankAgencyId, $account->accountId, $result->data->creditCardTransactions );
    		} else {
    			$error = ($result->error == null)?('Unknown error'):(json_encode($result->error));
    			$errors[] = "Error encountered when retrieving transactions for {$account->accountNumber}: {$error}";
    		}
    	}

        $result = new \stdClass;
        $result->transactions = $xactionsAdded;
        $result->errors = $errors;


    	return $result;
    }
}
