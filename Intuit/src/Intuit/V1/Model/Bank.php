<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 12/22/14
 * Time: 3:04 PM
 */

namespace Intuit\V1\Model;

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

        $this->clearBanks();
        $data     = json_decode($data, TRUE);
        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);
        $sql1     = "INSERT IGNORE INTO bank (bankId, bankAgencyId, bankName, baseUrl) VALUES ";

        $sql2 = [];
        $fp   = function ($name) use ($adapter) {
            return $adapter->platform->quoteValue($name);

        };
        foreach ($data as $key => $item) {
            $institutionId    = $item['institutionId'];
            $name      = @$fp($item['nsitutionName']);
            $baseUrl   = @$fp($item['homeUrl']);
            $agencyId  = $this->getBankAgencyId():

            $sql2[] = "($instituionId, $agencyId, $name, $baseUrl)";
        }

        if (count($sql2) > 0) {
            $sql = $sql1 . implode(',', $sql2);
            $statement = $adapter->createStatement($sql, []);
            $result    = $statement->execute();
        }
    }

    /**
     *  Remove all banks
    */
    private clearBanks() {

        $agencyId = $this->bankAgencyId;
        $config = $this->serviceLocator->get( 'Config' );
        $dbConfig = $config['db'];
        $adapter = new Adapter( $dbConfig );
        $dropSql = "DELETE * FROM bank WHERE bankAgencyId = {$agencyId}";
        $dropStmt = $adapter->createStatement( $dropSQL, [] );
        $dropResult = $dropStmt->execute(); 
    }

    public function bankAgencyId() {
        return INTUIT_AGENCY_ID;
    }
} 