<?php
namespace Intuit\V1\Rpc\RefreshBankList;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\Bank;
use Intuit\V1\Model\IntuitInterface;

class RefreshBankListController extends AbstractActionController
{
    public function refreshBankListAction()
    {

		$request = $this->getRequest();
        if ($request->isPost()) {

    		$intuit = new IntuitInterface( );
    		$result = $intuit->getInstitutions( 'privpass' );

    		if( $result->result == 'success' ) {
    			$bank = new Bank( $this->getServiceLocator() );
    			$bank->persistBanks( $result->data->institution );
    			$count = count( $result->data->institution );

            	$response = $this->getResponse();
            	$response->getHeaders()->addHeaders(array(
            	    'Content-Type' => 'application/json',
            	));

                $respDetails->result = 'success';
                $respDetails->banksLoaded = $count;
            	return $response->setContent( $respDetails );
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
