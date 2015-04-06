<?php
namespace Intuit\V1\Rpc\BankSearch;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\Bank;

class BankSearchController extends AbstractActionController
{
    public function bankSearchAction()
    {
    	$request = $this->getRequest();

        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

           	$bank = new Bank( $this->getServiceLocator() );
           	$results = $bank->searchBanks( $data->search_string );

           	$response = $this->getResponse();
           	$response->getHeaders()->addHeaders(array(
           	    'Content-Type' => 'application/json',
           	));
           	return $response->setContent( json_encode( $results ) );

        } else {
            return new ApiProblem(405, 'Method not allowed');
        }

    }
}
   
