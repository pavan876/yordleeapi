<?php
return array(
    'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => array(
        'POST' => array(
            'description' => 'Updates the list of banks from Intuit and return the count of the banks retrieved.',
            'response' => '{
     "result": "success",
     "message" : "# banks loaded."
}',
        ),
        'description' => 'Updates the list of banks from Intuit.',
    ),
    'Intuit\\V1\\Rpc\\BankSearch\\Controller' => array(
        'POST' => array(
            'description' => 'Retrieve the list of banks based on the search criteria provided. The search criteria utilizes the % to indicate wild cards.',
            'request' => '{
"searchString" : "search criteria"
}',
            'response' => '{
    "result": "success",
    "total":count,
    "banks": [
        {
            "bankId": "Unique Bank ID",
            "bankAgencyId": "Bank Agency ID",
            "bankName": "Name of the Bank",
            "baseUrl": "Bank Web Site"
        }
}',
        ),
        'description' => 'Retrieve the list of banks based on the search criteria provided.',
    ),
    'Intuit\\V1\\Rpc\\GetBankList\\Controller' => array(
        'GET' => array(
            'description' => 'Request the list of banks available for connecting customer accounts.',
            'request' => null,
            'response' => '{
    "result": "success",
    "total":count,
    "banks": [
        {
            "bankId": "Unique Bank ID",
            "bankAgencyId": "Bank Agency ID",
            "bankName": "Name of the Bank",
            "baseUrl": "Bank Web Site"
        }
}',
        ),
        'description' => 'Request the list of banks available for connecting customer accounts.',
    ),
    'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
        'POST' => array(
            'description' => 'Request the values required to authenticate access to a bank institution for the provided Bank Identifier.',
            'request' => '{
"bankId" : "Unique Bank Identifier"
}',
            'response' => 'The response is a list of values required for authorizing access to the account. The example below if for the Intuit test institution - 100000.
{
    "credentials": [
        {
            "name": "Banking Userid", // Name of the credential value, used in the login response
            "description": "Banking Userid", // Description of the value - for presentation to the User
            "mask": false, // Whether or not this field should be masked in the login form
            "status": "Active", // Whether or not this field is currently used
            "displayOrder": 1, // Order to be displayed on the login form
            "valueLengthMin": 1, // Minimum length for a valid response
            "valueLengthMax": 20, // Maximum length for a valid response
            "displayFlag": true, // Whether or not this value should be displayed as part of the form
            "instructions": "Enter banking userid (demo)" // Instructions for the user to enter this field
        },
        {
            "name": "Banking Password",
            "description": "Banking Password",
            "mask": true,
            "status": "Active",
            "displayOrder": 2,
            "valueLengthMin": 1,
            "valueLengthMax": 20,
            "displayFlag": true,
            "instructions": "Enter banking password (go)"
        }
    ],
    "result": "success"
}',
        ),
        'description' => 'Request the values required to authenticate access to a bank institution.',
    ),
    'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => array(
        'POST' => array(
            'description' => 'Remove the customer and all accounts and transactions.',
            'request' => '{
"customerId" : "Customer ID"
}',
            'response' => '{
    "result": "success"
}',
        ),
        'description' => 'Remove the customer and all accounts and transactions.',
    ),
    'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => array(
        'GET' => array(
            'description' => 'Return the list of transactions associated with Account ID and Customer ID provided.',
            'request' => null,
            'response' => '{
    "result": "success",
    "transactions": [
        {
            "customerId": "Customer Identifier",
            "transactionId": "Unique System Identifier",
            "bankId": "Unique Bank Identifier",
            "bankAgencyId": "Priv Pass Agency",
            "accountId": "System Account Id",
            "bankTransactionId": "Transaction ID from the Bank",
            "serverTransactionId": "Transaction ID for pending transfers",
            "checkNumber": "Check Number, if applicable",
            "refNumber": "Reference Number, if applicable",
            "confirmationNumber": "Confirmation Number, if applicable",
            "payeeId": "Payee Identifier",
            "payeeName": "Name of the Payee",
            "extendedPayeeName": "Longer Name of the Payee",
            "memo": "Information from the memo line",
            "type": "Bank\'s Transaction Type",
            "valueType": "Type of Value Provided",
            "currencyRate": "Exchange Rate",
            "originalCurrency": "0 if Currency Exchange, 1 if Not",
            "postedDate": "Date the Transaction was Posted",
            "userDate": "Date for Pending Transaction",
            "availableDate": "Date for Availability of Funds for Deposits",
            "amount": "Amount of the Transaction",
            "runningBalanceAmount": "Running Balance at the Time of the Transaction",
            "pending": "0 if yes, 1 if no"
        }
   ]
}',
        ),
        'description' => 'Return the list of transactions associated with Account ID and Customer ID provided.',
    ),
    'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
        'GET' => array(
            'description' => 'Returns the complete list of Bank Accounts for the customer identified by CustomerId.',
            'request' => null,
            'response' => '[
    {
        "accountId": "Unique System Account ID",
        "accountNumber": "Bank Account ID",
        "accountNickname": "Nickname Defined in Bank System",
        "customerId": "Customer Identifier",
        "bankId": "Bank Identifier",
        "bankAgencyId": "PrivPass Agency Identifier",
        "accountType": "Bank Account Type",
        "currencyCode": "Currency Type for Account",
        "active": "1 if Account is Active, 0 for Inactive Account",
        "displayPosition": "Display Position per Bank",
        "balanceAmount": "Balance Amount for the last Date",
        "balanceDate": "Balance Date"
    }
]',
        ),
        'description' => 'Returns the complete list of Bank Accounts for the customer identified by CustomerId.',
    ),
    'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
        'GET' => array(
            'description' => 'Return the set of transactions for the Customer across all account for Customer Identifier. If the Account Identifier is given, then filter the transactions for that account only. Pagination requires a query string of ?paging=true&page=#& limit=#, where # represents the page and limit number, respectively. If page is not provided, the first set of results is returned. If limit is not specified, 50 results are returned. An empty set of transactions will be returned at the end.',
            'request' => null,
            'response' => '{
    "result": "success",
    "transactions": [
        {
            "customerId": "Customer Identifier",
            "transactionId": "Unique System Identifier",
            "bankId": "Unique Bank Identifier",
            "bankAgencyId": "Priv Pass Agency",
            "accountId": "System Account Id",
            "bankTransactionId": "Transaction ID from the Bank",
            "serverTransactionId": "Transaction ID for pending transfers",
            "checkNumber": "Check Number, if applicable",
            "refNumber": "Reference Number, if applicable",
            "confirmationNumber": "Confirmation Number, if applicable",
            "payeeId": "Payee Identifier",
            "payeeName": "Name of the Payee",
            "extendedPayeeName": "Longer Name of the Payee",
            "memo": "Information from the memo line",
            "type": "Bank\'s Transaction Type",
            "valueType": "Type of Value Provided",
            "currencyRate": "Exchange Rate",
            "originalCurrency": "0 if Currency Exchange, 1 if Not",
            "postedDate": "Date the Transaction was Posted",
            "userDate": "Date for Pending Transaction",
            "availableDate": "Date for Availability of Funds for Deposits",
            "amount": "Amount of the Transaction",
            "runningBalanceAmount": "Running Balance at the Time of the Transaction",
            "pending": "0 if yes, 1 if no"
        }
   ]
}',
        ),
        'description' => 'Return the set of transactions for the Customer across all account for Customer Identifier. If the Account Identifier is given, then filter the transactions for that account only. Pagination is support when paging is identified as true, and a page and/or limit is provided. By default, the first 50 results are returned.',
    ),
    'Intuit\\V1\\Rpc\\RefreshBankLogin\\Controller' => array(
        'POST' => array(
            'description' => 'User RefreshBankLogin whenever a 103 error is returned to reset authorization.',
            'request' => '{
"customerId" : "Customer ID",  // Important as this is used to access all Customer Financial Account & Transactions
"loginId" : "Login ID from Customer Account",
"loginParameters": [
    { 
      "name": "Banking Userid", // Name from Get Site Login Form
      "value": "direct" // Value provided by the Customer
    },
    { 
      "name": "Banking Password",
      "value": "anyvalue"
    }

]
}',
            'response' => '{
    "result": "success",
}

{
    "result": "challenge",
    "data": {
        "challenge": [
            {  // One ore more of the following 
                "textOrImageAndChoice": [
                    "Question to which customer provides an open response"
                ],
                "textOrImageAndChoice": [
                    "Question to which customer selects a response",
                    { "val": "Option1", "text":"Display Text 1" },
                    { "val": "Option2", "text":"Display Text 2" }
                ],
                "textOrImageAndChoice": [
                    "Image prompt",
                    "base64 encoded image"
                ]
            }
        ],
        "challengeNodeId": "IP Address",
        "challengeSessionId": "hexadecimal code"
    }
}',
        ),
        'description' => 'User RefreshBankLogin whenever a 103 error is returned to reset authorization.',
    ),
    'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
        'POST' => array(
            'description' => null,
            'request' => '{
   "customerId" : "Unique Customer Identifier",
   "challengeNodeId" : "Challenge Node ID from Challenge Response",
   "challengeSessionId" : "Challenge Session ID from Challenge Response",
   "challengeResponses" : [ "List of Responses in order of challenges" ]
}',
            'response' => '{
    "result": "success",
    "accounts": Count,
    "transactions": {
        "transactions": Count,
        "errors": [] // list of errors, if any
    }
}

{
    "result": "challenge",
    "data": {
        "challenge": [
            {  // One ore more of the following 
                "textOrImageAndChoice": [
                    "Question to which customer provides an open response"
                ],
                "textOrImageAndChoice": [
                    "Question to which customer selects a response",
                    { "val": "Option1", "text":"Display Text 1" },
                    { "val": "Option2", "text":"Display Text 2" }
                ],
                "textOrImageAndChoice": [
                    "Image prompt",
                    "base64 encoded image"
                ]
            }
        ],
        "challengeNodeId": "IP Address",
        "challengeSessionId": "hexadecimal code"
    }
}',
        ),
        'description' => 'Accepts Challenge Response for Add Site Account identified by the Challenge Node and Session Ids.',
    ),
    'Intuit\\V1\\Rpc\\MFARequestForRefresh\\Controller' => array(
        'POST' => array(
            'description' => null,
            'request' => '{
   "customerId" : "Unique Customer Identifier",
    "loginId" : "Login ID from Customer Account",
   "challengeNodeId" : "Challenge Node ID from Challenge Response",
   "challengeSessionId" : "Challenge Session ID from Challenge Response",
   "challengeResponses" : [ "List of Responses in order of challenges" ]
}',
            'response' => '{
    "result": "success"
}

{
    "result": "challenge",
    "data": {
        "challenge": [
            {  // One ore more of the following 
                "textOrImageAndChoice": [
                    "Question to which customer provides an open response"
                ],
                "textOrImageAndChoice": [
                    "Question to which customer selects a response",
                    { "val": "Option1", "text":"Display Text 1" },
                    { "val": "Option2", "text":"Display Text 2" }
                ],
                "textOrImageAndChoice": [
                    "Image prompt",
                    "base64 encoded image"
                ]
            }
        ],
        "challengeNodeId": "IP Address",
        "challengeSessionId": "hexadecimal code"
    }
}',
        ),
        'description' => 'Accepts Challenge Response for Refresh Bank Login identified by the Challenge Node and Session Ids.',
    ),
    'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
        'POST' => array(
            'description' => 'Adds accounts from a bank for the identified customer and returns the number of accounts and transactions received.',
            'request' => '{
"customerId" : "Customer ID",  // Important as this is used to access all Customer Financial Account & Transactions
"bankId" : "Bank ID",
"loginParameters": [
    { 
      "name": "Banking Userid", // Name from Get Site Login Form
      "value": "direct" // Value provided by the Customer
    },
    { 
      "name": "Banking Password",
      "value": "anyvalue"
    }

]
}',
            'response' => '{
    "result": "success",
    "accounts": Count,
    "transactions": {
        "transactions": Count,
        "errors": [] // list of errors, if any
    }
   "otherAccounts":[
      { 
         "accountId" : "Unique Account Id",
         "bankId" : "Unique Bank Id",
         "accountNickname" : "Name the Customer Uses to Identify the Account",
         "description" : "Description of this Account"
       }
   ]
}

{
    "result": "challenge",
    "data": {
        "challenge": [
            {  // One ore more of the following 
                "textOrImageAndChoice": [
                    "Question to which customer provides an open response"
                ],
                "textOrImageAndChoice": [
                    "Question to which customer selects a response",
                    { "val": "Option1", "text":"Display Text 1" },
                    { "val": "Option2", "text":"Display Text 2" }
                ],
                "textOrImageAndChoice": [
                    "Image prompt",
                    "base64 encoded image"
                ]
            }
        ],
        "challengeNodeId": "IP Address",
        "challengeSessionId": "hexadecimal code"
    }
}',
        ),
        'description' => 'Adds accounts from a bank for the identified customer.',
    ),
    'Intuit\\V1\\Rpc\\UpdateBankAccountType\\Controller' => array(
        'GET' => array(
            'description' => null,
            'request' => null,
            'response' => null,
        ),
        'POST' => array(
            'description' => null,
            'request' => '{
   "customerId" : "Unique Customer Identifier",
   "accountId" : "Unique Account Identifier",
   "accountClassification" : "bankAccountType or creditAccountType",
   "accountType" : "value from the below"
   // bankAccountType: CHECKING, SAVINGS, MONEYMRKT, RECURRINGDEPOSIT, CD, CASHMANAGEMENT, OVERDRAFT
   // creditAccountType: CREDITCARD, LINEOFCREDIT, OTHER"
}',
            'response' => '{
     "result" : "success"
}',
        ),
        'description' => 'Update the Account Type for Bank Account, generally used when an "other" shows up.',
    ),
);
