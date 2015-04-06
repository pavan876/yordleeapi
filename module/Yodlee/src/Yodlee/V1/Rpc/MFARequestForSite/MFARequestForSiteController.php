<?php
namespace Yodlee\V1\Rpc\MFARequestForSite;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\AddAccount;

class MFARequestForSiteController extends AbstractActionController
{
    public function mFARequestForSiteAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return new ApiProblem(405, 'Method not allowed');
        }

        $data       = $request->getContent();
        $data       = json_decode($data, TRUE);
        $customerId = $data['customer_id'];
        $addAccount = new AddAccount($customerId, $this->getServiceLocator());

        return $addAccount->putMFARequest($data);
    }
}
