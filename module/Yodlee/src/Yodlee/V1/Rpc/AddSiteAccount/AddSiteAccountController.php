<?php
namespace Yodlee\V1\Rpc\AddSiteAccount;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\TableGateway\TableGateway;
use ZF\Rest\Exception\RuntimeException;
use Yodlee\V1\Model\AddAccount;

/**
 * Class AddSiteAccountController
 *
 * @package Yodlee\V1\Rpc\AddSiteAccount
 * @author  Hari Dornala
 * @date    26 Jun 2014
 */
class AddSiteAccountController extends AbstractActionController
{
    private $customerId;
    private $yodlee;

    public function addSiteAccountAction()
    {
        $request = $this->getRequest();
        $data    = $request->getContent();
        $data    = json_decode($data, TRUE);

        // Check if account is already added
        if ($response = $this->isAccountAlreadyAdded($data)) {
            return $response;
        }

        $addAccount = new AddAccount($data['customer_id'], $this->getServiceLocator());
        unset($data['customer_id']);

        return $addAccount->process($data);
    }

    protected function isAccountAlreadyAdded($data)
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $bank    = new TableGateway('customer_bank', $adapter);

        $result = $bank->select(array(
            'siteId'       => $data['siteId'],
            'BankUserName' => $data['credentialFields[0].value']
        ));

        if ($result->count() > 0) {
            $account = $result->current();
            if ($account->customerId == $data['customer_id']) {
                return FALSE;
//                return $this->createResponse(200, 'success', 'Account is already added');
            } else {
                return $this->createResponse(200, 'fail', 'Account is already added by another user');
            }
        }

        return FALSE;
    }

    protected function createResponse($code, $result, $message)
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders()->addHeaders(array('Content-Type' => 'application/json'));
        $response->setStatusCode($code);
        $response->setContent(json_encode(array(
            'result'  => $result,
            'message' => $message
        )));

        return $response;
    }
}
