<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 12/22/14
 * Time: 3:04 PM
 */

namespace Intuit\V1\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Intuit\V1\Model\Bank;

/**
 * Class Bank
 * @package Yodlee\V1\Model
 * @author  Hari Dornala
 * @date    22 Dec 2014
 */
/*
DROP TABLE IF EXISTS `customer_account`;
CREATE TABLE `customer_account` (
  `accountId` bigint(20) NOT NULL,
  `accountNumber` bigint(20) NOT NULL,  
  `accountNickname` varchar(50) NOT NULL,
  `customerId` bigint(20) NOT NULL,
  `bankId` varchar(10) NOT NULL,
  `bankAgencyId` int(11) NOT NULL,
  `accountType` varchar(50) NOT NULL,
  `currencyCode` varchar(3) NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `displayPosition` int(10),
  `balanceAmount` DECIMAL(10,2) DEFAULT 0.0,
  `balanceDate` DATE,
  PRIMARY KEY (`accountId`),
  KEY `fk_bank_agency_mast_customer_account_mast1_idx` (`bankAgencyId`),
  KEY `fk_bank_mast_customer_account_mast1_idx` (`bankId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
class CustomerAccount
{
    private $serviceLocator;

    /**
     * @param $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function persistCustomerAccounts($customerId, $data)
    {

        //$data     = json_decode($data, TRUE);
        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $sql2 = [];
        $fp   = function ($name) use ($adapter) {
            return $adapter->platform->quoteValue($name);

        };
        $bankCount = 0;
        foreach ($data as $key => $item) {
            // Only process bank accounts
            if( $item->type != 'bankingAccount' ) continue;
            $bankCount++;
            $accountId          = $item->accountId;
            $accountNumber      = $item->accountNumber;
            $accountNickname    = $item->accountNickname;
            $bankId             = $item->institutionId;
            $bankAgencyId       = Bank::getBankAgencyId();
            $accountType        = $item->bankingAccountType;
            $currencyCode       = $item->currencyCode;
            $active             = ($item->status == 'ACTIVE')?(1):(0);
            $displayPosition    = $item->displayPosition;
            $balanceAmount      = $item->balanceAmount;
            $balanceDate        = substr( $item->balanceDate, 0, 10 );


            $sql   = 'INSERT INTO customer_account (customerId, accountId, accountNumber, accountNickname, bankId, bankAgencyId, accountType, currencyCode, active, displayPosition, balanceAmount, balanceDate )';
            $sql   .= " VALUES ('{$customerId}', {$accountId}, {$accountNumber}, '{$accountNickname}', '{$bankId}', {$bankAgencyId}, '{$accountType}', '{$currencyCode}', {$active}, {$displayPosition}, {$balanceAmount}, '{$balanceDate}')";
            $sql   .= " ON DUPLICATE KEY UPDATE `accountNickname`='{$accountNickname}', `active`={$active}, `displayPosition`={$displayPosition}, `balanceAmount`={$balanceAmount}, `balanceDate` = '{$balanceDate}'";

            $statement = $adapter->createStatement($sql, []);
            $result    = $statement->execute();
        }

        return "{$bankCount} accounts added.";

    }

    public function getAccountInfo( $customerId, $accountId ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $sql        = "SELECT * FROM customer_account WHERE `customerId` = {$customerId} AND `accountId` = {$accountId} ";
        $statement  = $adapter->createStatement($sql, []);
        $result     = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize( $result );

        return $resultSet->current();
    }

    public function getAccounts( $customerId ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $sql        = "SELECT * FROM customer_account WHERE `customerId` = {$customerId}";
        $statement  = $adapter->createStatement($sql, []);
        $result     = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize( $result );

        return $resultSet->toArray();

    }

} 