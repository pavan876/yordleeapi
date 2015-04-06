<?php
namespace Yodlee\V1\Rpc\FetchBankTransactions;

use Zend\Mvc\Controller\AbstractActionController;
use Yodlee\V1\Model\YodleeBroker;
use Yodlee\V1\Model\BankAgency;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\TableGateway\TableGateway;
use ZF\Rest\Exception\RuntimeException;

class FetchBankTransactionsController extends AbstractActionController
{
    const FETCH_LIMIT = 100;
    private $yodlee;
    private $customerId;
    private $userAccounts;
    private $searchIdentifier;
    private $numberOfHits;

    public function fetchBankTransactionsAction()
    {
        $this->customerId = $this->getEvent()->getRouteMatch()->getParam('customer_id');
        $bankAgency       = new BankAgency($this->getServiceLocator(), $this->customerId);
        $this->yodlee     = new YodleeBroker($this->getServiceLocator(), $bankAgency);
        $accounts         = $this->getUserAccounts();

        if (empty($accounts)) {
            return array(
                'result' => 'fail',
                'message' => 'No transactions saved',
                'reason'  => 'No matched accounts found'
            );
        } else {
            $this->userAccounts = $accounts;
        }

        $response               = $this->executeUserSearchRequest();
        $this->numberOfHits     = $response->numberOfHits;
        $this->searchIdentifier = $response->searchIdentifier->identifier;
        $result                 = $this->saveYodleeTransactions($response->searchResult->transactions);
        $transactions_fetched   = $result['transactions_fetched'];
        $transactions_saved     = $result['transactions_saved'];

        for ($i = self::FETCH_LIMIT; $i < $response->numberOfHits; $i = $i + self::FETCH_LIMIT) {
            $response1 = $this->getUserTransactions($i);
            $result    = $this->saveYodleeTransactions($response1->transactions);

            $transactions_fetched += $result['transactions_fetched'];
            $transactions_saved += $result['transactions_saved'];
        }

        return array(
            'result'               => 'success',
            'transactions_fetched' => $transactions_fetched,
            'transactions_saved'   => $transactions_saved
        );
    }

    protected function getUserAccounts()
    {
        $adapter = $this->serviceLocator->get('Zend\Db\Adapter\Adapter');

        $sql = "SELECT itemAccountId
                FROM customer_bank_item_account a
                JOIN customer_bank_item b ON a.itemId=b.itemId
                JOIN customer_bank c ON b.memSiteAccId=c.memSiteAccId
                WHERE c.customerId=?";

        $statement = $adapter->createStatement($sql, array($this->customerId));
        $result    = $statement->execute();

        if ($result->count() > 0) {
            $accounts = array();
            foreach ($result as $account) {
                $accounts[] = $account['itemAccountId'];
            }
        }

        return $accounts;
    }

    protected function executeUserSearchRequest()
    {
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

        return json_decode($response);
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

    protected function saveYodleeTransactions($response)
    {
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
            `currencyCode`
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
                $merchantName      = (isset($transaction->description->merchantName)) ? mysql_real_escape_string($transaction->description->merchantName) : '';
                $categoryName      = mysql_real_escape_string($transaction->category->categoryName);
                $accountNumber     = str_pad(strtoupper($transaction->account->accountNumber), 16, "X", STR_PAD_LEFT);

                $sqlPart2 .= "(
                        {$transaction->viewKey->transactionId},
                        {$transaction->account->itemAccountId},
                        {$this->customerId},
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
                        '{$transaction->amount->currencyCode}'
                    ),";
            }
        }

        if ($sqlPart2) {
            $sqlPart2 = rtrim($sqlPart2, ',');
            $statement = $adapter->query($sqlPart1 . $sqlPart2);
            $statement->execute(array());
        }

        return array(
            'transactions_fetched' => $fetchCount,
            'transactions_saved'   => $saveCount
        );
    }
}
