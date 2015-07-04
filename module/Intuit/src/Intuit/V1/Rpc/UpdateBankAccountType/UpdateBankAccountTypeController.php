<?php
namespace Intuit\V1\Rpc\UpdateBankAccountType;

use Zend\Mvc\Controller\AbstractActionController;

class UpdateBankAccountTypeController extends AbstractActionController
{
    public function updateBankAccountTypeAction()
    {
    	  $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

            $intuitInterface = new IntuitInterface( );
    				$intuitResult = $intuitInterface->updateAccountType( 	$data->customerId, 
    																															$data->accountId, 
    																															$data->accountClassification,
    																															$data->accountType );

            $response = $this->getResponse();
						$response->getHeaders()->addHeaders( 
							array(
			           'Content-Type' => 'application/json',
							)
						);

    				switch( $intuitResult->result ) {
    					case 'success': 		    			
    						$result = new \stdClass;
			    			$result->result = 'success';
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
}
