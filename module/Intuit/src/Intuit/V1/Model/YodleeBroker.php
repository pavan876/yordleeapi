<?php
namespace Yodlee\V1\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Zend\Db\TableGateway\TableGateway;
use ZF\Rest\Exception\RuntimeException;

/**
 * Class YodleeBroker
 * Handles all requests to yodlee api.
 * Developer Url:
 * http://developer.yodlee.com/
 * Rest API reference:
 * http://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/Aggregation_REST_API_Reference
 * Developer Data:
 * https://devnow.yodlee.com/
 *
 * @package Yodlee\V1\Model
 * @author  Hari Dornala
 * @date    24 Jun 2014
 */
class YodleeBroker
{
    const  BASE_URL = 'https://rest.developer.yodlee.com/services/srest/restserver/v1.0';

    protected $serviceLocator;
    protected $bankAgency;
    protected $config;
    protected $userSessionToken;
    protected $cobSessionToken;

    /**
     * @param $serviceLocator
     * @param BankAgency $bankAgency
     */
    public function __construct($serviceLocator, BankAgency $bankAgency)
    {
        $this->serviceLocator = $serviceLocator;
        $this->bankAgency     = $bankAgency;
        $config               = $this->serviceLocator->get('Config');
        $this->config         = $config['api']['yodlee'];

        $cobSessionToken        = $this->setcobSessionToken();
        $this->userSessionToken = $this->bankAgency->getUserSessionToken($cobSessionToken);
    }

    /**
     * Function: post
     *
     * @author   Hari Dornala
     * @date     24 Jun 2014
     *
     * @param string $subUrl
     * @param array $data
     *
     * @throws \ZF\Rest\Exception\RuntimeException
     * @return mixed
     */
    public function post($subUrl, $data)
    {
        if (!$this->cobSessionToken) {
            throw new RuntimeException('Yodlee CobSessionToken not found');
        }

        if (!$this->userSessionToken) {
            throw new RuntimeException('Yodlee UserSessionToken not found');
        }

        $url    = self::BASE_URL . $subUrl;
        $client = new Client();

        $data = array_merge($data, array(
            'userSessionToken' => $this->userSessionToken,
            'cobSessionToken'  => $this->cobSessionToken
        ));

        $data = array(
            'body' => $data
        );

        try {
            $response = $client->post($url, $data);
        } catch (ClientException $e) {
            echo $e->getRequest();
            echo $e->getResponse();
            exit;
        }

        $body = $response->getBody();

        return $body;
    }

    /**
     * Function: getTokens
     * Retrieves userSessionToken and cobSessionToken from database
     * Checks whether tokens are expired
     * If tokens are expired, sends a fresh request to api to get fresh tokens
     * If fresh token is requested, updates the db with fresh token information.
     *
     * @author   Hari Dornala
     * @date     24 Jun 2014
     * @return array
     */
    private function setcobSessionToken()
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $gateway = new TableGateway('config', $adapter);

        $config = $gateway->select(array(
            'entity' => 'yodlee'
        ));

        $cobSessionToken          = FALSE;
        $cobSessionTokenTimeStamp = FALSE;

        foreach ($config as $row) {
            ${$row->attribute} = $row->val;
        }

        if ($this->isCobSessionTokenExpired($cobSessionTokenTimeStamp)) {
            $cobSessionToken = $this->createCobSessionToken();

            if ($cobSessionToken) {
                $gateway->update(array(
                    'val' => $cobSessionToken
                ), array(
                    'entity'    => 'yodlee',
                    'attribute' => 'cobSessionToken'
                ));

                $gateway->update(array(
                    'val' => time()
                ), array(
                    'entity'    => 'yodlee',
                    'attribute' => 'cobSessionTokenTimeStamp'
                ));
            }
        }

        $this->cobSessionToken = $cobSessionToken;

        return $cobSessionToken;
    }

    /**
     * Function: isCobSessionTokenExpired
     *
     * @author   Hari Dornala
     * @date     24 Jun 2014
     *
     * @param    (int) $ts
     *
     * @return bool
     */
    private function isCobSessionTokenExpired($ts = FALSE)
    {
        if (!$ts) {
            return TRUE;
        }

        $ts         = (int)$ts;
        $expireTime = $ts + (98 * 60); // Expires at every 100 minutes

        return (time() > $expireTime);
    }

    /**
     * Function: setCobSessionToken
     *
     * @author   Hari Dornala
     * @date     24 Jun 2014
     * @return mixed
     */
    private function createCobSessionToken()
    {
        $url = self::BASE_URL . '/authenticate/coblogin';

        $client = new Client();

        $data = array(
            'body' => array(
                'cobrandLogin'    => $this->config['cobrandLogin'],
                'cobrandPassword' => $this->config['cobrandPassword']
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

        return $body['cobrandConversationCredentials']['sessionToken'];
    }
}