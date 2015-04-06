<?php
/**
 * Project: PrivyPASS.com
 * Author: Hari Dornala
 * Date: 8/28/14
 * Time: 5:20 PM
 */

namespace Yodlee\V1\Model;

use Aws\CloudFront\Exception\Exception as AwsException;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use Zend\Db\TableGateway\TableGateway;
use ZF\Apigility\Documentation\Api;
use ZF\ApiProblem\ApiProblem;

use Guzzle\Http\Client;
use Guzzle\Plugin\Async\AsyncPlugin;

use Privy\Tools\Cities;
use Privy\Tools\Logger;
use Zend\Log\Logger as ZendLogger;
use Analytics\V1\Model\CustomerSpendingAnalytics;

use Common\V1\Model\Mail\Mandrill\Mail;
use Common\V1\Model\Mail\Mandrill\Message;

/**
 * Class Transactions
 *
 * @package Yodlee\V1\Model
 * @author  Hari Dornala
 */
class Transactions
{
    const FETCH_LIMIT = 100;
    private $memSiteAccId = FALSE;
    private $serviceLocator;
    private $customerId;
    private $dbAdapter;
    private $yodlee;
    private $userAccounts;
    private $numberOfHits;
    private $searchIdentifier;

    public function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->dbAdapter      = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');
    }

    public function processByMemSiteAccId($memSiteAccId)
    {
        if (!$memSiteAccId) {
            $apiProblem = new ApiProblem(404, 'Unable to process, no memSiteAccId');

            return $apiProblem->toArray();
        }

        $customerId = $this->retrieveCustomerId($memSiteAccId);

        if (!$customerId) {
            Logger::log("PROC-BY-MEM-SITE-ACC-ID: Customer Id is not available for memSiteAccId=" . $memSiteAccId, ZendLogger::ERR);
            $apiProblem = new ApiProblem(404, 'User not found for given account id');

            return $apiProblem->toArray();
        }

        Logger::log("PROC-BY-MEM-SITE-ACC-ID: Starting transaction processing for Customer:" . $customerId . " Account Id: " . $memSiteAccId);

        $result = $this->process($customerId);


        if (is_array($result) && $result['result'] == 'success') {
            $spendingAnalytics = new CustomerSpendingAnalytics($this->serviceLocator, $customerId);
            $spendingAnalytics->process();

            Logger::log("PROC-BY-MEM-SITE-ACC-ID: Process ended for Customer:" . $customerId . " Account Id: " . $memSiteAccId . " successfully");

            // Check unmapped merchants and send mail to admin
            $this->sendMailForUnmappedMerchants();

            return TRUE;
        }

        Logger::log("PROC-BY-MEM-SITE-ACC-ID: Process ended for Customer:" . $customerId . " Account Id: " . $memSiteAccId . " failed");

        return FALSE;

    }

    public function processAllAccounts()
    {
        $sql = "SELECT DISTINCT(customerId) FROM customer_bank";

        $statement = $this->dbAdapter->createStatement($sql, []);
        $result    = $statement->execute();

        foreach ($result as $item) {
            $customerId = $item['customerId'];
            Logger::log("PROCESS-ALL-ACCOUNTS: Processing User: " . $customerId);
            $result = $this->process($customerId);
            Logger::log("PROCESS-ALL-ACCOUNTS: Finished User: " . $customerId);

            if (is_array($result) && $result['result'] == 'success') {
                $spendingAnalytics = new CustomerSpendingAnalytics($this->serviceLocator, $customerId);
                Logger::log("PROCESS-ALL-ACCOUNTS: Spending Analytics Process started for Customer:" . $customerId);
                $spendingAnalytics->process();

                Logger::log("PROCESS-ALL-ACCOUNTS: Spending Analytics Process ended for Customer:" . $customerId . " finished");
            }
        }

        // Check unmapped merchants and send mail to admin
        $this->sendMailForUnmappedMerchants();
    }

    private function sendMailForUnmappedMerchants()
    {
        $sql = "SELECT DISTINCT(description)
                FROM customer_bank_transaction
                WHERE categoryName='Restaurants/Dining'
                AND merchantId IS NULL";

        $statement = $this->dbAdapter->createStatement($sql, []);
        $result    = $statement->execute();

        if ($result->count() > 0) {

            $desc = [];

            foreach ($result as $item) {
                $desc[] = $item['description'];
            }

            $data = [
                'body'    => 'Hi <br> The following descriptions are still unmapped <br>' . implode(', ', $desc),
                'subject' => 'Yodlee unmapped descriptions',
                'from'    => 'Admin@PrivPass.com',
                'to'      => [
                    [
                        "email" => 'info@privpass.com',
                        "name"  => "PrivPASS Info",
                        "type"  => 'to'
                    ],
                    [
                        "email" => 'hari.dorna@gmail.com',
                        "name"  => "Hari Dornala",
                        "type"  => 'cc'
                    ]
                ]
            ];

            $message = new Message($data);
            $mailer  = new Mail($this->serviceLocator);
            $mailer->sendMail($message);
        }
    }


    private function process($customerId)
    {
        $bankAgency   = new BankAgency($this->serviceLocator, $customerId);
        $this->yodlee = new YodleeBroker($this->serviceLocator, $bankAgency);

        $accounts = $this->getUserAccounts($customerId);

        if (empty($accounts)) {
            Logger::log("No accounts available for customer: " . $customerId, ZendLogger::ERR);

            return array(
                'result'  => 'fail',
                'message' => 'No transactions saved',
                'reason'  => 'No matched accounts found'
            );

        } else {
            $this->userAccounts = $accounts;
        }

// print_r($this->userAccounts); exit;

        $response           = $this->executeUserSearchRequest($customerId);
        $this->numberOfHits = $response->numberOfHits;

        if (!$this->numberOfHits) {
            return array(
                'result'  => 'fail',
                'message' => 'No transactions found for customerId: ' . $customerId
            );
        }

        $this->searchIdentifier = $response->searchIdentifier->identifier;
        $result                 = $this->saveYodleeTransactions($response->searchResult->transactions, $customerId);
        $transactions_fetched   = $result['transactions_fetched'];
        $transactions_saved     = $result['transactions_saved'];

        for ($i = self::FETCH_LIMIT; $i < $response->numberOfHits; $i = $i + self::FETCH_LIMIT) {
            $response1 = $this->getUserTransactions($i);
            $result    = $this->saveYodleeTransactions($response1->transactions, $customerId);
            $transactions_fetched += $result['transactions_fetched'];
            $transactions_saved += $result['transactions_saved'];
        }

        return array(
            'result'               => 'success',
            'transactions_fetched' => $transactions_fetched,
            'transactions_saved'   => $transactions_saved
        );
    }

    /**
     * Function: retrieveCustomerId
     * Retrieves customerId based on bankAccountId
     *
     * @author   Hari Dornala
     *
     * @param $memSiteAccId
     *
     * @return bool
     */
    private function retrieveCustomerId($memSiteAccId)
    {
        $customerBank = new TableGateway('customer_bank', $this->dbAdapter);

        $result = $customerBank->select(array(
            'memSiteAccId' => $memSiteAccId
        ));

        if ($result->count() == 0) {
            return FALSE;
        }

        return $result->current()->customerId;
    }

    protected function getUserAccounts($customerId)
    {
        Logger::log("Fetching customer accounts");
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');

        $sql = "SELECT itemAccountId
                FROM customer_bank_item_account a
                JOIN customer_bank_item b ON a.itemId = b.itemId
                JOIN customer_bank c ON b.memSiteAccId = c.memSiteAccId
                WHERE c.customerId=?";

        $statement = $adapter->createStatement($sql, array($customerId));

        $result = $statement->execute();

        if ($result->count() > 0) {
            $accounts = array();
            foreach ($result as $account) {
                $accounts[] = $account['itemAccountId'];
            }
        }

        return $accounts;
    }

    protected function executeUserSearchRequest($customerId)
    {
        Logger::log("Performing yodlee-api::executeUserSearchRequest");
        $subUrl = '/jsonsdk/TransactionSearchService/executeUserSearchRequest';

        $data     = array(
            "transactionSearchRequest.containerType"             => "All",
            "transactionSearchRequest.higherFetchLimit"          => "500",
            "transactionSearchRequest.lowerFetchLimit"           => "1",
            "transactionSearchRequest.resultRange.endNumber"     => self::FETCH_LIMIT,
            "transactionSearchRequest.resultRange.startNumber"   => 1,
            "transactionSearchRequest.searchFilter.currencyCode" => "USD",
            "transactionSearchRequest.ignoreUserInput"           => "true"
        );
        $response = $this->yodlee->post($subUrl, $data);

        Logger::log("Finished yodlee-api::executeUserSearchRequest");

        return json_decode($response);
    }

    protected function saveYodleeTransactions($response, $customerId)
    {
        Logger::log("Saving Transations");
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');

        $sqlPart1 = "INSERT IGNORE INTO `customer_bank_transaction` (
            `transactionId`,
            `itemAccountId`,
            `customerId`,
            `accountName`,
            `accountNumber`,
            `containerType`,
            `postDate`,
            `description`,
            `simpleDescription`,
            `transactionType`,
            `merchantName`,
            `categoryId`,
            `categoryName`,
            `amount`,
            `currencyCode`,
            `city`,
            `state`
        ) VALUES ";

        $fetchCount = 0;
        $saveCount  = 0;
        $sqlPart2   = '';

        foreach ($response as $transaction) {

            $fetchCount++;
            if (in_array($transaction->account->itemAccountId, $this->userAccounts)) {
                $saveCount++;
                $postDate          = date('Y-m-d H:i:s', strtotime($transaction->postDate));
                $accountName       = mysql_real_escape_string($transaction->account->accountName);
                $description       = mysql_real_escape_string($transaction->description->description);
                $simpleDescription = mysql_real_escape_string($transaction->description->simpleDescription);
                $merchantName      =
                    (isset($transaction->description->merchantName)) ? mysql_real_escape_string($transaction->description->merchantName) : '';
                $categoryName      = mysql_real_escape_string($transaction->category->categoryName);
                $accountNumber     = str_pad(strtoupper($transaction->account->accountNumber), 16, "X", STR_PAD_LEFT);

                $city  = '';
                $state = $this->getState($description, $categoryName);
                if ($state) {
                    $city = $this->getCity($description, $state);
                }

                $sqlPart2 .= "(
                        {$transaction->viewKey->transactionId},
                        {$transaction->account->itemAccountId},
                        {$customerId},
                        '{$accountName}',
                        '{$accountNumber}',
                        '{$transaction->viewKey->containerType}',
                        '{$postDate}',
                        '{$description}',
                        '{$simpleDescription}',
                        '{$transaction->transactionType}',
                        '{$merchantName}',
                        '{$transaction->category->categoryId}',
                        '{$categoryName}',
                        '{$transaction->amount->amount}',
                        '{$transaction->amount->currencyCode}',
                        '{$city}',
                        '{$state}'
                    ),";
            }
        }

        if ($sqlPart2) {
            $sqlPart2 = rtrim($sqlPart2, ',');
//            Logger::log("SQL\n" . $sqlPart1 . $sqlPart2);

            $statement = $adapter->query($sqlPart1 . $sqlPart2);
            $statement->execute(array());

            Logger::log("Finished Saving Transations");
        }

        return array(
            'transactions_fetched' => $fetchCount,
            'transactions_saved'   => $saveCount
        );
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

    private function ingoreState($category)
    {
        $categories = Util\PresetData::getYelpMapCategories();

        if (in_array($category, $categories)) {
            return FALSE;
        }

        return TRUE;
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

    protected function getUserTransactions($i)
    {
        $subUrl    = '/jsonsdk/TransactionSearchService/getUserTransactions';
        $endNumber = $i + self::FETCH_LIMIT;
        if ($endNumber > $this->numberOfHits) {
            $endNumber = $this->numberOfHits;
        }

        $data = array(
            "searchFetchRequest.searchIdentifier.identifier"   => $this->searchIdentifier,
            "searchFetchRequest.searchResultRange.startNumber" => $i,
            "searchFetchRequest.searchResultRange.endNumber"   => $endNumber
        );

        $response = $this->yodlee->post($subUrl, $data);

        return json_decode($response);
    }
}