<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 9/6/14
 * Time: 2:42 PM
 */

namespace Yodlee\V1\Model;

use Zend\Db\TableGateway\TableGateway;


class TransactionCityMap
{
    private $serviceLocator;
    private $customerId;

    public function __construct($serviceLocator, $customerId)
    {
        $this->customerId     = $customerId;
        $this->serviceLocator = $serviceLocator;
    }

    public function process()
    {
        $transactions = $this->getUserTransactions();
    }

    private function getUserTransactions()
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
        $tblTransactions = new TableGateway('customer_bank_transaction', $adapter);

        $sql = "SELECT *
                FROM customer_bank_transaction a
                JOIN customer_bank_item_account b ON a.itemAccountId=b.itemAccountId
                JOIN customer_bank_item c ON c.itemId=b.itemId
                JOIN customer_bank d ON d.memSiteAccId=c.memSiteAccId
                WHERE d.customerId=?
                AND a.transactionType='debit'
                AND IFNULL(a.state, '')=''
                AND IFNULL(a.merchantName, '')!=''";

        $statement = $adapter->createStatement($sql, array($this->customerId));

        //        echo $statement->getSql(); exit;

        $result = $statement->execute();
    }

    private function getState($description, $category)
    {
        if ($this->ingoreState($category)) {
            return '';
        }

        $states = [
            'AL',
            'AK',
            'AZ',
            'AR',
            'CA',
            'CO',
            'CT',
            'DE',
            'DC',
            'FL',
            'GA',
            'HI',
            'ID',
            'IL',
            'IN',
            'IA',
            'KS',
            'KY',
            'LA',
            'ME',
            'MD',
            'MA',
            'MI',
            'MN',
            'MS',
            'MO',
            'MT',
            'NE',
            'NV',
            'NH',
            'NJ',
            'NM',
            'NY',
            'NC',
            'ND',
            'OH',
            'OK',
            'OR',
            'PA',
            'RI',
            'SC',
            'SD',
            'TN',
            'TX',
            'UT',
            'VT',
            'VA',
            'WA',
            'WV',
            'WI',
            'WY'
        ];

        $words = explode(' ', $description);

        $last       = array_pop($words);
        $lastButOne = array_pop($words);
        $lastButTwo = array_pop($words);

        if (strlen($last) == 2 && in_array($last, $states)) {
            return $last;
        }

        $endsWith = substr($last, -2);
        if (strlen($endsWith) == 2 && in_array($endsWith, $states)) {
            return $endsWith;
        }

        if (strlen($lastButOne) == 2 && in_array($lastButOne, $states)) {
            return $lastButOne;
        }

        $endsWith = substr($lastButOne, -2);
        if (strlen($endsWith) == 2 && in_array($endsWith, $states)) {
            return $endsWith;
        }

        if (strlen($lastButTwo) == 2 && in_array($lastButTwo, $states)) {
            return $lastButTwo;
        }

        $endsWith = substr($lastButTwo, -2);
        if (strlen($endsWith) == 2 && in_array($endsWith, $states)) {
            return $endsWith;
        }

        return '';
    }

    private function getCity($description, $state)
    {
        $description = strtolower($description);
        $state       = strtoupper($state);

        $cities = Cities::getCitiesByState($state);

        foreach ($cities as $city) {
            $city = strtolower($city);

            $pos = strpos($description, $city);

            if ($pos !== FALSE) {
                return ucwords($city);
            }
        }

        return '';
    }

    private function ingoreState($category)
    {
        $categories = Util\PresetData::getYelpMapCategories();

        if (in_array($category, $categories)) {
            return FALSE;
        }

        return TRUE;
    }
}