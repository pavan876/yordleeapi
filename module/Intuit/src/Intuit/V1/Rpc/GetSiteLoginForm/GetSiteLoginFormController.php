<?php
namespace Intuit\V1\Rpc\GetSiteLoginForm;

use Zend\Mvc\Controller\AbstractActionController;

use Intuit\V1\Model\IntuitInterface;

class GetSiteLoginFormController extends AbstractActionController
{
    public function getSiteLoginFormAction()
    {
    	$request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

    		$intuit = new IntuitInterface( );
    		$site_details = $intuit->getInstitutionDetails( $data->customer_id, $data->bank_id );

    		if( $site_details->result == 'success' ) {
	    		$result = new \stdClass;
	    		$result->credentials = $site_details->data->keys->key;
	    		$result->result = 'success';


	            $response = $this->getResponse();
	            $response->getHeaders()->addHeaders(array(
	                'Content-Type' => 'application/json',
	            ));

	            return $response->setContent( json_encode( $result ) );
            } else {
            	if( $result->error == null )
            		return new ApiProblem( 500, 'Unknown error' );
            	else
            		return new ApiProblem( 500, $result->error );
            }

        } else {
            return new ApiProblem(405, 'Method not allowed');
        }
        
    }
}
