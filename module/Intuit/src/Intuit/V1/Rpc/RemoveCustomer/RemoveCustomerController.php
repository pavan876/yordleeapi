<?php
namespace Intuit\V1\Rpc\RemoveCustomer;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\IntuitInterface;
use Intuit\V1\Model\CustomerTransaction;
use Intuit\V1\Model\CustomerAccount;

class RemoveCustomerController extends AbstractActionController
{
    public function removeCustomerAction()
    {

		$request = $this->getRequest();
        $serviceLocator = $this->getServiceLocator();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

    		$intuit = new IntuitInterface( );
    		$result = $intuit->deleteCustomer( $data->customerId );

    		if( $result->result == 'success' ) {

                $customerXaction = new CustomerTransaction( $serviceLocator );
                $customerXaction->deleteCustomer( $data->customerId );

                $customerAccount = new CustomerAccount( $serviceLocator );
                $customerAccount->deleteCustomer( $data->customerId );

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
