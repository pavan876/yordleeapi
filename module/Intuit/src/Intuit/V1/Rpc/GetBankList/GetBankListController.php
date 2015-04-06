<?php
namespace Intuit\V1\Rpc\GetBankList;

use Zend\Mvc\Controller\AbstractActionController;
use Intuit\V1\Model\Bank;

class GetBankListController extends AbstractActionController
{
    public function getBankListAction()
    {
       	$request = $this->getRequest();

        if ($request->isGet()) {
            $data = $request->getContent();
            $data = json_decode($data);

           	$bank = new Bank( $this->getServiceLocator() );
           	$results = $bank->getBankList();

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
