<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 8/12/14
 * Time: 2:54 PM
 */

namespace Yodlee\V1\Model;

use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;

use Guzzle\Http\Client;
use Guzzle\Plugin\Async\AsyncPlugin;

use Aws\Common\Aws;
use Console\Model\SQS;
use Privy\Tools\Logger;

class AddAccount
{
    const SLEEP = 2;

    private $mfaCount = 0;
    private $refreshCount = 0;

    protected $customerId;
    protected $serviceLocator;
    protected $yodlee;
    protected $response;

    protected $bankDetails;
    protected $data;

    public function __construct($customerId, $serviceLocator)
    {
        $this->customerId     = $customerId;
        $this->serviceLocator = $serviceLocator;
        $bankAgency           = new BankAgency($this->serviceLocator, $this->customerId);
        $this->yodlee         = new YodleeBroker($this->serviceLocator, $bankAgency);
    }

    public function process($data)
    {
        $this->data = $data;
        // Flow diagram
        // https://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/API_Flow/Add_Site_Account

        $response = $this->addSiteAccount($data);

        $this->bankDetails = $response;
//        print_r($response);
//        exit;

        $siteRefreshStatus = @$response['siteRefreshInfo']['siteRefreshStatus']['siteRefreshStatus'];

        switch ($siteRefreshStatus) {
            // List of Statuses
            // https://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/Data_Model/Yodlee_Constants#Content_Service_Level_Refresh_Status
            case 'REFRESH_TRIGGERED':
            case 'REFRESH_ALREADY_IN_PROGRESS':
                $this->handleRefresh($response);
                break;
            case 'LOGIN_SUCCESS':
            case 'REFRESH_COMPLETED':
            case 'PARTIAL_COMPLETE': // This need to be examined again
            case 'REFRESHED_TOO_RECENTLY':
            case 'REFRESH_COMPLETED_ACCOUNTS_ALREADY_AGGREGATED':
                Logger::log("Account successfully added with memSiteAccId: $memSiteAccId");
                $memSiteAccId    = $response['siteAccountId'];
                $this->addSQSMessage($memSiteAccId);
                $this->response = array(
                    'result'   => 'success',
                    'message'  => 'Account added successfully',
                    'SiteAccountId' => $memSiteAccId,
                    'siteInfo' => $response['siteInfo']
                );
                break;
            case 'LOGIN_FAILURE':
            case 'REFRESH_NEVER_INITIATED':
            case 'REFRESH_TIMED_OUT':
            case 'REFRESH_CANCELLED':
            case 'REFRESH_COMPLETED_WITH_UNCERTAIN_ACCOUNT':
            case 'SITE_CANNOT_BE_REFRESHED':
            default:
                $this->response = array(
                    'result'  => 'fail',
                    'message' => 'Sorry unable to add account',
                    'reason'  => $siteRefreshStatus
                );
        }

        return $this->response;
    }

    public function addSQSMessage($memSiteAccId)
    {
        $sqs = new SQS($this->serviceLocator);
        $sqs->addMessage('yodlee-transactions', $memSiteAccId);
    }

    public function putMFARequest($data)
    {
        $data['userResponse.objectInstanceType'] = 'com.yodlee.core.mfarefresh.MFAQuesAnsResponse';

        $subUrl         = '/jsonsdk/Refresh/putMFARequestForSite';
        $response       = $this->yodlee->post($subUrl, $data);
        $response       = \GuzzleHttp\json_decode($response, 1);
        $memSiteAccId   = $data['memSiteAccId'];
        $this->mfaCount = 0;

        $this->handleMFAResponse($memSiteAccId);

        return $this->response;
    }

    protected function handleRefresh($response)
    {
        $siteRefreshMode = $response['siteRefreshInfo']['siteRefreshMode']['refreshMode'];
        $memSiteAccId    = $response['siteAccountId'];
        if ($siteRefreshMode == 'MFA') {
            $this->handleMFAResponse($memSiteAccId);
        } else {
            $this->getSiteRefreshInfo($memSiteAccId);
        }
    }

    public function handleMFAResponse($memSiteAccId)
    {
        $this->mfaCount++;

        if ($this->mfaCount > 20) {
            $this->response = array(
                'result'  => 'fail',
                'message' => 'Sorry unable to add account, Maximum MFA Refresh attempts (' . $this->mfaCount . ') completed'
            );

            return;
        }
        $subUrl   = '/jsonsdk/Refresh/getMFAResponseForSite';
        $response = $this->yodlee->post($subUrl, array('memSiteAccId' => $memSiteAccId));
        $response = \GuzzleHttp\json_decode($response, 1);

//        print_r($response); exit;

        $errorCode          = @$response['errorCode'];
        $errorOccurred      = @$response['errorOccurred'];
        $isMessageAvailable = @$response['isMessageAvailable'];

//        print_r(array(
//            'count' => $this->mfaCount,
//            'method' => 'getMFAResponseForSite',
//            'response' => $response
//        ));

        if (isset($errorCode) && $errorCode == 0) {
            $this->getSiteRefreshInfo($memSiteAccId);
        } else if ($isMessageAvailable) {
            $response = $this->handleMFAResponse($memSiteAccId);

            $this->response = array(
                'result' => 'mfa',
                'mfa'    => $response
            );

            return;
        } else {
            sleep(self::SLEEP); // wait before request
            return $this->handleMFAResponse($memSiteAccId);
        }
    }

    protected function getSiteRefreshInfo($memSiteAccId)
    {
        $this->refreshCount++;

        if ($this->refreshCount > 20) {
            $this->response = array(
                'result'  => 'fail',
                'message' => 'Sorry unable to add account, Maximum Refresh attempts (' . $this->refreshCount . ') completed'
            );

            return;
        }

        $subUrl   = '/jsonsdk/Refresh/getSiteRefreshInfo';
        $response = $this->yodlee->post($subUrl, array('memSiteAccId' => $memSiteAccId));
        $response = \GuzzleHttp\json_decode($response, 1);

        $siteRefreshStatus = @$response['siteRefreshStatus']['siteRefreshStatus'];
        $code              = @$response['code'];

        //        print_r(array(
        //            'count' => $this->refreshCount,
        //            'method' => 'getSiteRefreshInfo',
        //            'siteRefreshStatus' => $siteRefreshStatus,
        //            'code' => $code,
        //            'response' => $response
        //        ));

        if ($code == 0) {
            if (!($siteRefreshStatus == 'REFRESH_COMPLETED' || $siteRefreshStatus == 'REFRESH_TIMED_OUT')) {
                sleep(self::SLEEP);

                return $this->getSiteRefreshInfo($memSiteAccId);
            }
        } else {
            sleep(self::SLEEP);

            return $this->getSiteRefreshInfo($memSiteAccId);
        }

        if ($siteRefreshStatus == 'REFRESH_TIMED_OUT') {
            $this->response = array(
                'result'  => 'fail',
                'message' => 'Sorry unable to add account, Request timed out'
            );

            return;
        } else if ($siteRefreshStatus == 'REFRESH_COMPLETED') {
            Logger::log("Saving account with memSiteAccId: $memSiteAccId");
            $this->saveAccount();
            $this->addSQSMessage($memSiteAccId);
            $this->response = array(
                'result'        => 'success',
                'message'       => 'Account added successfully',
                'SiteAccountId' => $memSiteAccId,
                'response'      => $response
            );

            return;
        }
    }

    protected function addSiteAccount($data)
    {
        $subUrl   = '/jsonsdk/SiteAccountManagement/addSiteAccount1';
        $response = $this->yodlee->post($subUrl, $data);
        $response = \GuzzleHttp\json_decode($response, 1);

        return $response;
    }


    private function saveAccount()
    {
        $this->addCustomerHasBankRecord();
        $itemSummaries = $this->getItemSummariesForSite();
        $itemSummaries = json_decode($itemSummaries);
        $this->addItemSummaries($itemSummaries);

//        $awsConfig = APPLICATION_PATH . '/config/autoload/aws.local.php';
//        $aws = Aws::factory($awsConfig);
//        $client = $aws->get('Sqs');
//        $queueUrl = 'https://sqs.us-west-1.amazonaws.com/656488620472/transactions';
//
//        $client->sendMessage(array(
//            'QueueUrl'    => $queueUrl,
//            'MessageBody' => '{"itemAccountId":"2343543"}',
//        ));


        // Async Test
        //        $client = new Client('http://hari.localhost/test/longresponse.php');
        //        $client->addSubscriber(new AsyncPlugin());
        //        $client->get()->send();
    }

    private function addCustomerHasBankRecord()
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $bank    = new TableGateway('bank', $adapter);

        // See if we have this bank already in our db.
        $result = $bank->select(array(
            'siteId' => $this->bankDetails['siteInfo']['siteId']
        ));

        if ($result->count() == 0) {
            $bank->insert(array(
                'siteId'       => $this->bankDetails['siteInfo']['siteId'],
                'orgId'        => $this->bankDetails['siteInfo']['orgId'],
                'bankName'     => $this->bankDetails['siteInfo']['defaultDisplayName'],
                'bankAgencyId' => YODLEE_AGENCY_ID,
                'baseUrl'      => $this->bankDetails['siteInfo']['baseUrl'],
            ));
        }

        $adapter      = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $customerBank = new TableGateway('customer_bank', $adapter);

        // See if we have this bank already in our db.
        $result = $customerBank->select(array(
            'memSiteAccId' => $this->bankDetails['siteAccountId']
        ));

        $key       = time() . mt_rand(1000, 5000) . YODLEE_ENCRYPT_KEY;
        $cipher    = new \Zend\Filter\Encrypt\BlockCipher($key);
        $loginForm = json_encode($this->data);
        $loginForm = $cipher->encrypt($loginForm);

        if ($result->count() == 0) {
            $result = $customerBank->insert(array(
                'memSiteAccId'    => $this->bankDetails['siteAccountId'],
                'customerId'      => $this->customerId,
                'siteId'          => $this->bankDetails['siteInfo']['siteId'],
                'orgId'           => $this->bankDetails['siteInfo']['orgId'],
                'bankAgencyId'    => YODLEE_AGENCY_ID,
                'bankName'        => $this->bankDetails['siteInfo']['defaultDisplayName'],
                'siteRefreshMode' => $this->bankDetails['siteRefreshInfo']['siteRefreshMode']['refreshMode'],
                'suggestedFlow'   => $this->bankDetails['siteRefreshInfo']['suggestedFlow']['suggestedFlow'],
                'created'         => date('Y-m-d h:i:s'),
                'baseUrl'         => $this->bankDetails['siteInfo']['baseUrl'],
                'BankUserName'    => $this->data['credentialFields[0].value'],
                'key'             => $key,
                'loginForm'       => $loginForm
            ));
        }
    }

    protected function getItemSummariesForSite()
    {
        $data = array(
            'memSiteAccId' => $this->bankDetails['siteAccountId']
        );

        $subUrl   = '/jsonsdk/DataService/getItemSummariesForSite';
        $response = $this->yodlee->post($subUrl, $data);

        return $response;
    }

    protected function addItemSummaries($itemSummaries)
    {

        foreach ($itemSummaries as $item) {
            $createDate               = explode('T', $item->refreshInfo->itemCreateDate);
            $createDate               = $createDate[0];
            $lastSuccessfulDataUpdate = explode('T', $item->refreshInfo->lastSuccessfulDataUpdate);
            $lastSuccessfulDataUpdate = $lastSuccessfulDataUpdate[0];

            $adapter  = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
            $bankItem = new TableGateway('customer_bank_item', $adapter, new Feature\RowGatewayFeature('itemId'));

            $result = $bankItem->select(array(
                'itemId' => $item->itemId
            ));

            if ($result->count() == 0) {
                $bankItem->insert(array(
                    'itemId'                   => $item->itemId,
                    'memSiteAccId'             => $item->memSiteAccId,
                    'containerName'            => $item->contentServiceInfo->containerInfo->containerName,
                    'itemDisplayName'          => $item->itemDisplayName,
                    'refreshMode'              => $item->refreshInfo->refreshMode,
                    'itemCreateDate'           => $createDate,
                    'lastSuccessfulDataUpdate' => $lastSuccessfulDataUpdate
                ));
            } else {
                $row = $result->current();
                $row->lastSuccessfulDataUpdate = $lastSuccessfulDataUpdate;
                $row->save();
            }

            foreach ($item->itemData->accounts as $account) {
                $this->addItemAccount($account, $item);
            }
        }
    }

    protected function addItemAccount($account, $item)
    {
        $accountType = $item->contentServiceInfo->containerInfo->containerName;
        $itemId      = $item->itemId;

        $adapter         = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $bankItemAccount = new TableGateway('customer_bank_item_account', $adapter);

        $result = $bankItemAccount->select(array(
            'itemAccountId' => $account->itemAccountId
        ));

        $accountNumber = str_pad(strtoupper($account->accountNumber), 16, "X", STR_PAD_LEFT);

        if ($result->count() == 0) {
            $bankItemAccount->insert(array(
                'itemAccountId'    => $account->itemAccountId,
                'itemId'           => $itemId,
                'accountId'        => $account->accountId,
                'baseTagDataId'    => $account->baseTagDataId,
                'accountType'      => $accountType,
                'accountName'      => isset($account->accountName) ? $account->accountName : '',
                'accountHolder'    => isset($account->accountHolder) ? $account->accountHolder : '',
                'accountNumber'    => $accountNumber,
                'runningBalance'   => isset($account->runningBalance->amount) ? $account->runningBalance->amount : '',
                'lastPayment'      => isset($account->lastPayment->amount) ? $account->lastPayment->amount : '',
                'availableCredit'  => isset($account->availableCredit->amount) ? $account->availableCredit->amount : '',
                'availableCash'    => isset($account->availableCash->amount) ? $account->availableCash->amount : '',
                'totalCreditLine'  => isset($account->totalCreditLine->amount) ? $account->totalCreditLine->amount : '',
                'totalCashLimit'   => isset($account->totalCashLimit->amount) ? $account->totalCashLimit->amount : '',
                'availableBalance' => isset($account->availableBalance->amount) ? $account->availableBalance->amount : '',
                'currentBalance'   => isset($account->currentBalance->amount) ? $account->currentBalance->amount : ''
            ));
        } else {
            $bankItemAccount->update(array(
                'runningBalance'   => isset($account->runningBalance->amount) ? $account->runningBalance->amount : '',
                'lastPayment'      => isset($account->lastPayment->amount) ? $account->lastPayment->amount : '',
                'availableCredit'  => isset($account->availableCredit->amount) ? $account->availableCredit->amount : '',
                'availableCash'    => isset($account->availableCash->amount) ? $account->availableCash->amount : '',
                'totalCreditLine'  => isset($account->totalCreditLine->amount) ? $account->totalCreditLine->amount : '',
                'totalCashLimit'   => isset($account->totalCashLimit->amount) ? $account->totalCashLimit->amount : '',
                'availableBalance' => isset($account->availableBalance->amount) ? $account->availableBalance->amount : '',
                'currentBalance'   => isset($account->currentBalance->amount) ? $account->currentBalance->amount : ''
            ), array(
                'itemAccountId' => $account->itemAccountId
            ));
        }
    }
}