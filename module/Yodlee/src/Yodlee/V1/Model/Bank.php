<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 12/22/14
 * Time: 3:04 PM
 */

namespace Yodlee\V1\Model;

use Zend\Db\Adapter\Adapter;

/**
 * Class Bank
 * @package Yodlee\V1\Model
 * @author  Hari Dornala
 * @date    22 Dec 2014
 */
class Bank
{
    private $serviceLocator;

    /**
     * @param $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function persistBanks($data)
    {
        $data     = json_decode($data, TRUE);
        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db'];
        $adapter  = new Adapter($dbConfig);
        $sql1     = "INSERT IGNORE INTO bank (siteId, orgId, bankAgencyId, bankName, baseUrl, loginForm) VALUES ";

        $sql2 = [];
        $fp   = function ($name) use ($adapter) {
            return $adapter->platform->quoteValue($name);

        };
        foreach ($data as $key => $item) {
            $loginForm = json_encode(@$item['loginForms'][0]);
            $loginForm = $fp($loginForm);
            $siteId    = $item['siteId'];
            $orgId     = $item['orgId'];
            $name      = @$fp($item['defaultDisplayName']);
            $baseUrl   = @$fp($item['baseUrl']);

            $sql2[] = "($siteId, $orgId, 1, $name, $baseUrl, $loginForm)";
        }

        if (count($sql2) > 0) {
            $sql = $sql1 . implode(',', $sql2);
            $statement = $adapter->createStatement($sql, []);
            $result    = $statement->execute();
        }
    }
} 