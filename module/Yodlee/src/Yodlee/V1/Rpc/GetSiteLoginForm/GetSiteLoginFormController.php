<?php
namespace Yodlee\V1\Rpc\GetSiteLoginForm;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class GetSiteLoginFormController
 *
 * @package Yodlee\V1\Rpc\GetSiteLoginForm
 * @author Hari Dornala
 * @date 26 Jun 2014
 */
class GetSiteLoginFormController extends AbstractActionController
{
    public function getSiteLoginFormAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getContent();
            $data = json_decode($data);

            $result = $this->getData($data->site_id);

            $response = $this->getResponse();
            $response->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/json',
            ));

            return $response->setContent($result);
        } else {
            return new ApiProblem(405, 'Method not allowed');
        }
    }

    public function getData($siteId)
    {
        $bankAgency = new BankAgency($this->getServiceLocator());
        $yodlee     = new YodleeBroker($this->getServiceLocator(), $bankAgency);

//        $subUrl = '/jsonsdk/SiteAccountManagement/getSiteLoginForm';
        $subUrl = '/jsonsdk/SiteTraversal/getSiteInfo';

        $data = array(
//            'siteId' => $siteId
            'siteFilter.reqSpecifier' => 16,
            'siteFilter.siteId'       => $siteId
        );

        $response = $yodlee->post($subUrl, $data);

        return $response;
    }
}
