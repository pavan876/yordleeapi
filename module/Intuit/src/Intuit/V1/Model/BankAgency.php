<?php
namespace Yodlee\V1\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;

/**
 * Class BankAgency
 * Maintains details of customer Bank agency
 *
 * @package Yodlee\V1\Model
 */
class BankAgency
{
    protected $serviceLocator;

    /**
     * @param $serviceLocator
     * @param $userId
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getUserSessionToken($cobSessionToken)
    {
        // Commented out this code for the purpose of demo
        //$credentialsRow = $this->getCredentials();

        //if (!$this->isUserSessionTokenExpired($credentialsRow->session_token_timestamp)) {
        //    return $credentialsRow->session_token;
        //}

        $url    = YodleeBroker::BASE_URL . '/authenticate/login';
        $client = new Client();
        $data   = array(
            'body' => array(
                'cobSessionToken' => $cobSessionToken,
                // Hard coding these values for the purpose of demo
                'login'           => 'sbMemLadMar20151',
                'password'        => 'sbMemLadMar20151#123'
            )
        );

        try {
            $response = $client->post($url, $data);
        } catch (ClientException $e) {
            echo $e->getRequest();
            echo $e->getResponse();
            exit;
        }

        $body = $response->json();

        $userSessionToken = $body['userContext']['conversationCredentials']['sessionToken'];

        //if ($userSessionToken) {
        //    $userSessionTokenTimestamp               = time();
        //    $credentialsRow->session_token           = $userSessionToken;
        //    $credentialsRow->session_token_timestamp = $userSessionTokenTimestamp;
        //    $credentialsRow->save();
        //}

        return $userSessionToken;
    }

    public function getCredentials()
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $table   = new TableGateway('customer_has_bank_agency', $adapter);
        $result  = $table->select(array(
            'customer_id'           => $this->userId,
            'bank_agency_agency_id' => $this->getBankAgencyId()
        ));;

        $row = $result->current();

        if (!$row) {
            $data           = $this->addBankAgency($table);
            $credentials_id = $data['bank_agency_credentials_id'];
        } else {
            $credentials_id = $row->bank_agency_credentials_id;
        }

        $table  = new TableGateway('bank_agency_credentials', $adapter, new Feature\RowGatewayFeature('id'));
        $result = $table->select(array(
            'id' => $credentials_id
        ));

        $row = $result->current();

        return $row;
    }

    public function addBankAgency($table)
    {
        $data = array(
            'customer_id'                => $this->userId,
            'bank_agency_agency_id'      => $this->getBankAgencyId(),
            'bank_agency_credentials_id' => $this->getBankAgencyCredentialsId()
        );
        $table->insert($data);

        return $data;
    }

    /**
     * Function: isUserSessionTokenExpired
     * Checks if token is expired
     *
     * @author   Hari Dornala
     * @date     24 Jun 2014
     *
     * @param    $ts
     *
     * @return bool
     */
    public function isUserSessionTokenExpired($ts = FALSE)
    {
        if (!$ts) {
            return TRUE;
        }

        $ts         = (int)$ts;
        $expireTime = $ts + (28 * 60); // Expires at every 30 minutes

        return (time() > $expireTime);
    }

    /**
     * Function: getBankAgencyId
     * Dummy function to take care of Bank Agency Id in future. Currently Yodlee is hardcoded.
     *
     * @author   Hari Dornala
     * @return int
     */
    protected function getBankAgencyId()
    {
        return YODLEE_AGENCY_ID;
    }

    /**
     * Function: getBankAgencyCredentialsId
     * Dummy function to take care of BankAgencyCredentials Id in future. Currently Yodlee is hardcoded.
     *
     * @author   Hari Dornala
     * @return int
     */
    protected function getBankAgencyCredentialsId()
    {
        return BANK_AGENCY_CREDENTIALS_ID;
    }
}