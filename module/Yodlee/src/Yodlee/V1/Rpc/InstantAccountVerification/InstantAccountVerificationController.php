<?php
namespace Yodlee\V1\Rpc\InstantAccountVerification;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\IAV\IAV;

class InstantAccountVerificationController extends AbstractActionController
{
    public function instantAccountVerificationAction()
    {
        $iav = new IAV();

        return $iav->processIAV();
    }
}
