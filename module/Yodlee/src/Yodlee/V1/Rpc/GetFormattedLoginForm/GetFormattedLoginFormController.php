<?php
namespace Yodlee\V1\Rpc\GetFormattedLoginForm;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class GetFormattedLoginFormController
 * @package Yodlee\V1\Rpc\GetFormattedLoginForm
 * @author Hari Dornala
 * @date 31 Dec 2014
 */
class GetFormattedLoginFormController extends AbstractActionController
{
    public function getFormattedLoginFormAction()
    {
        $siteId = $this->getEvent()->getRouteMatch()->getParam('site_id');

        return $this->getLoginFormFromDb($siteId);
    }

    private function getLoginFormFromDb($siteId)
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $bank    = new TableGateway('bank', $adapter);

        $result = $bank->select(['siteId' => $siteId]);

        if ($result->count() > 0) {
            $bank      = $result->current();
            $loginForm = $bank->loginForm;

            if (trim($loginForm)) {
                $loginForm = json_decode($loginForm, TRUE);
                $loginForm = $this->formatLoginForm($loginForm, $siteId);
            } else {
                $loginForm = [];
            }

            return [
                'siteId'    => $siteId,
                'orgId'     => $bank->orgId,
                'bankName'  => $bank->bankName,
                'loginForm' => $loginForm
            ];
        }

        return FALSE;
    }

    private function formatLoginForm($loginForm, $siteId)
    {
        $form = [
            "siteId"                        => $siteId,
            "credentialFields.enclosedType" => "com.yodlee.common.FieldInfoSingle"
        ];

        foreach ($loginForm['componentList'] as $key => $item) {
            $credentialField = "credentialFields[". $key . "]";
            foreach ($item as $k => $v) {
                if ($k == "fieldType") {
                    $form[$credentialField . ".fieldType.typeName"] = $this->handleBoolean($v["typeName"]);
                } else {
                    $form[$credentialField . '.' . $k] = $this->handleBoolean($v);
                }
            }

            $form[$credentialField . '.value'] = 'XXXXXXXXXXX';
        }

        return $form;
    }

    private function handleBoolean($val) {
        if ($val === true) {
            return "1";
        }

        if ($val === false) {
            return "0";
        }

        return $val;
    }
}
