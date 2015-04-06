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
DROP TABLE IF EXISTS `customer_transaction`;
CREATE TABLE `customer_transaction` (
  `customerId` bigint(20) NOT NULL,
  `transactionId` bigint(20) NOT NULL,
  `bankId` varchar(10) NOT NULL,
  `bankAgencyId` int(11) NOT NULL,
  `accountId` bigint(20) NOT NULL,
  `bankTransactionId` varchar(50) NOT NULL,
  `serverTransactionId` varchar(50) DEFAULT NULL,
  `checkNumber` varchar(50) DEFAULT NULL,
  `refNumber` varchar(50) DEFAULT NULL,
  `confirmationNumber` varchar(50) DEFAULT NULL,
  `payeeId` varchar(50) DEFAULT NULL,
  `payeeName` varchar(100) DEFAULT NULL,
  `extendedPayeeName` varchar(200) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `valueType` varchar(50) DEFAULT NULL,
  `currencyRate` DECIMAL (10,5) DEFAULT 1.0,
  `originalCurrency` tinyint(1) DEFAULT 1,
  `postedDate` DATE DEFAULT NULL,
  `userDate` DATE DEFAULT NULL,
  `availableDate` DATE DEFAULT NULL,
  `amount` DECIMAL (10,2) DEFAULT 0,
  `runningBalanceAmount` DECIMAL (10,2) DEFAULT 0.0,
  `pending` TINYINT(1) DEFAULT 0,
  

  PRIMARY KEY (`transactionId`),
  KEY `fk_customer_bank_mast_account_id_mast1_idx` (`bankAgencyId`),
  KEY `fk_bank_agency_mast_customer_xact_mast1_idx` (`bankAgencyId`),
  KEY `fk_bank_mast_customer_xact_mast1_idx` (`bankId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
class CustomerTransaction
{
    private $serviceLocator;
    private $transactionColumnNames = array( 
                                            'serverTransactionId' => true,
                                            'checkNumber' => true,
                                            'refNumber' => true,
                                            'confirmationNumber' => true,
                                            'payeeId' => true,
                                            'payeeName' => true,
                                            'extendedPayeeName' => true,
                                            'memo' => true,
                                            'type' => true,
                                            'valueType' => true,
                                            'currencyRate' => false,
                                            'originalCurrency' => true,
                                            'postedDate' => true,
                                            'userDate' => true,
                                            'availableDate' => true,
                                            'amount' => false,
                                            'runningBalanceAmount' => false,
                                            'pending' => false );
    /**
     * @param $serviceLocator
     */
    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function persistCustomerTransactions( $customerId, $bankId, $bankAgencyId, $accountId, $transactions )
    {

        //$data     = json_decode($data, TRUE);
        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $defaultCols = array( 'customerId', 'bankId', 'bankAgencyId', 'accountId' );
        $defaultVals = array( $customerId, $bankId, $bankAgencyId, $accountId );
        $cols = array_merge( $defaultCols );
        $vals = array_merge( $defaultVals );
        $updateVals = array();

        $setVal = function( $record, $attrib, $quoted = true ) use ( &$cols, &$vals, &$updateVals ){
            if( isset( $record->$attrib ) ) {
                $value = ($quoted)?("'{$record->$attrib}'"):($record->$attrib);
                if( $value === false ) $value = 0;
                if( $value === true ) $value = 1;
                $cols[] = "`{$attrib}`";
                $vals[] = $value;
                $updateVals[] = "`{$attrib}`={$value}";
            }
        };

        foreach ($transactions as $key => $item) {

            $cols[] = 'transactionId';
            $vals[] = "{$item->id}";
            foreach( $this->transactionColumnNames as $columnName => $quoted )
                $setVal( $item, $columnName, $quoted );


            $insertCols = implode( ',', $cols );
            $insertVals = implode( ',', $vals );
            $updateStmt = implode( ',', $updateVals );
            $sql   = "INSERT INTO customer_transaction ( {$insertCols} ) VALUES ( {$insertVals} )";
            $sql   .= ' ON DUPLICATE KEY UPDATE ' . $updateStmt;

            $statement = $adapter->createStatement($sql, []);
            $result    = $statement->execute();

            $cols = array_merge( $defaultCols );
            $vals = array_merge( $defaultVals );
            $updateVals = [];
        }

        return count($transactions) . ' transactions processed.';

    }

    public function getLastTransactionDate( $customerId, $accountId ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $sql        = "SELECT MAX(`userDate`) AS `postedDate` FROM customer_transaction WHERE `customerId` = {$customerId} AND `accountId` = {$accountId} AND `pending` = 0";
        $statement  = $adapter->createStatement($sql, []);
        $result     = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize( $result );
        if( $resultSet->current() === false ) {
            $sql        = "SELECT MAX(`postedDate`) AS `postedDate` FROM customer_transaction WHERE `customerId` = {$customerId} AND `accountId` = {$accountId}";
            $statement  = $adapter->createStatement($sql, []);
            $result     = $statement->execute();

            $resultSet->initialize( $result );
        }

        return $resultSet->current();

    }

    public function getTransactions( $customerId, $accountId = null, $startDate = null, $endDate = null , $start = null, $limit = null ) {

        $config   = $this->serviceLocator->get('Config');
        $dbConfig = $config['db-intuit'];
        $adapter  = new Adapter($dbConfig);

        $sql        = "SELECT * FROM customer_transaction WHERE `customerId` = {$customerId}"; 

        if( $accountId != null )
            $sql .= " AND `accountId` = {$accountId}";

        if( $endDate != null ) {
            $sql .= " (`postedDate` BETWEEN '{$startDate}' AND '{$endDate}'";
        } else if( $startDate!= null ) {
            $sql .= " (`postedDate` >= '{$startDate}'";
        }

        $sql .= " ORDER BY postedDate";

        if( $limit != null )
            $sql .= " LIMIT {$start}, {$limit}";

        $statement  = $adapter->createStatement($sql, []);
        $result     = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize( $result );

        return $resultSet->toArray();

    }

} 