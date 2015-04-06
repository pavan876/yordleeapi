<?php
namespace Yodlee\V1\Rpc\BankSearch;

use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use Yodlee\V1\Model\Bank;

class BankSearchController extends AbstractActionController
{
    public function bankSearchAction()
    { 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

            $result = $this->searchBanks($data->customer_id, $data->search_string);

            $response = $this->getResponse();
            $response->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/json',
            ));

            return $response->setContent($result);
        } else {
            return new ApiProblem(405, 'Method not allowed');
        }
    }

    public function searchBanks($customerId, $searchString)
    {
        $bankAgency = new BankAgency($this->getServiceLocator(), $customerId);
        $yodlee = new YodleeBroker($this->getServiceLocator(), $bankAgency);

        $subUrl = '/jsonsdk/SiteTraversal/searchSite';

        $data = array(
            'siteSearchString' => $searchString
        );

        $response = $yodlee->post($subUrl, $data);

        $bank = new Bank($this->getServiceLocator());
        $bank->persistBanks($response);

        return $response;
    }
}
