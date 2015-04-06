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
/*
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `bankId` varchar(10) DEFAULT NULL,
  `bankAgencyId` int(11) NOT NULL,
  `bankName` varchar(200) DEFAULT NULL,
  `baseUrl` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`bankId`),
  KEY `fk_bank_mast_bank_agency_mast1_idx` (`bankAgencyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
        //$data     = json_decode($data, TRUE);
        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);
        $sql1     = "INSERT IGNORE INTO bank (bankId, bankAgencyId, bankName, baseUrl) VALUES ";

        $sql2 = [];
        $fp   = function ($name) use ($adapter) {
            return $adapter->platform->quoteValue($name);

        };
        foreach ($data as $key => $item) {
            $institutionId    = $item->institutionId;
            $name      = @$fp($item->institutionName);
            $baseUrl   = @$fp($item->homeUrl);
            $agencyId  = $this->getBankAgencyId();

            $sql2[] = "($institutionId, $agencyId, $name, $baseUrl)";
        }

        if (count($sql2) > 0) {
            $sql = $sql1 . implode(',', $sql2);
            $statement = $adapter->createStatement($sql, []);
            $result    = $statement->execute();
        }
    }

    public function searchBanks( $searchString ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $agencyId  = $this->getBankAgencyId();
        $searchMatch = str_replace( ' ', '%', $searchString );

        $sql = "SELECT bankId, bankAgencyId, bankName, baseUrl FROM bank WHERE bankAgencyId = {$agencyId} AND bankName like '%{$searchMatch}%'";

        $statement = $adapter->createStatement($sql, []);
        $result = $statement->execute();
        $count = $result->count();

       if( $count > 0 )  {

            $banks = array();
            foreach( $result as $bank ) {
                $banks[] = $bank;
            }

            return array(
                "result"    => "success",
                "total"     => $count,
                "banks"     => $banks
            );

       } else {
            return array(
                "result"    => "success",
                "total"     => $count,
                "banks"     => [],
                "message"   => 'No banks found'
            );
       }


    }


    public function getBankList( ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $agencyId  = Bank::getBankAgencyId();

        $sql = "SELECT bankName FROM bank WHERE bankAgencyId = {$agencyId}";

        $statement = $adapter->createStatement($sql, []);
        $result = $statement->execute();
        $count = $result->count();

       if( $count > 0 )  {

            $banks = array();
            foreach( $result as $bank ) {
                $banks[] = $bank;
            }

            return array(
                "result"    => "success",
                "total"     => $count,
                "banks"     => $banks
            );

       } else {
            return array(
                "result"    => "success",
                "total"     => $count,
                "banks"     => [],
                "message"   => 'No banks found'
            );
       }
    }

    /**
     *  Remove all banks
    */
    private function clearBanks() {

        $agencyId = $this->getBankAgencyId();
        $config = $this->serviceLocator->get( 'Config' );
        $dbConfig = $config['db-intuit'];
        $adapter = new Adapter( $dbConfig );
        $dropSql = "DELETE FROM bank WHERE bankAgencyId = {$agencyId}";
        $dropStmt = $adapter->createStatement( $dropSql, [] );
        $dropResult = $dropStmt->execute(); 
    }

    public static function getBankAgencyId() {
        return INTUIT_AGENCY_ID;
    }
} 