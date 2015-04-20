<?php
namespace Intuit\V1\Rpc\MFARequestForRefresh;

use Zend\Mvc\Controller\AbstractActionController;

class MFARequestForRefreshController extends AbstractActionController
{
   public function mFARequestForRefreshAction()
   {
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

    	  $this->intuitInterface = new IntuitInterface( );
    		$intuitResult = $this->intuitInterface->updateInstitutionLoginChallenge( $data->customerId,
											$data->loginId, 
											$data->challengeNodeId,
											$data->challengeSessionId,
											$data->challengeResponses );

    		return $intuitResult;
    }
}
