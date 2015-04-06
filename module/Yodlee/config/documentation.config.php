<?php
return array(
    'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
        'POST' => array(
            'description' => 'This REST API adds a member site account associated with a particular site. (i.e., John Doe wants to aggregate his banking, loans and investment accounts held in IQ Bank). Refresh is initiated for the item with a priority of REFRESH_PRIORITY_HIGH. This API is called after getting a login form for a particular site using GetSiteLoginForm service.

For further info read Yodlee documentation at 
https://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/Aggregation_REST_API_Reference/addSiteAccount1',
            'request' => '{
	"customer_id": "100000000001",
	
	"siteId": "2852",
    "credentialFields.enclosedType": "com.yodlee.common.FieldInfoSingle",
	"credentialFields[0].valueIdentifier": "LOGIN",
	"credentialFields[0].valueMask": "LOGIN_FIELD",
	"credentialFields[0].fieldType.typeName": "IF_LOGIN",
	"credentialFields[0].size": 20,
	"credentialFields[0].maxlength": 40,
	"credentialFields[0].name": "LOGIN",
	"credentialFields[0].displayName": "Online ID",
	"credentialFields[0].value": "xxxxxxxxxxxxx",
	"credentialFields[0].isEditable": 1,
	"credentialFields[0].isOptional": 0,
	"credentialFields[0].isEscaped": 0,
	"credentialFields[0].helpText": "5371",
	"credentialFields[0].isOptionalMFA": 0,
	"credentialFields[0].isMFA": 0,

	"credentialFields[1].valueIdentifier": "PASSWORD",
	"credentialFields[1].valueMask": "LOGIN_FIELD",
	"credentialFields[1].fieldType.typeName": "IF_PASSWORD",
	"credentialFields[1].size": 20,
	"credentialFields[1].maxlength": 20,
	"credentialFields[1].name": "PASSWORD",
	"credentialFields[1].displayName": "Passcode",
	"credentialFields[1].value": "xxxxxxxxxxxxx",	
	"credentialFields[1].isEditable": 1,
	"credentialFields[1].isOptional": 0,
	"credentialFields[1].isEscaped": 0,
	"credentialFields[1].helpText": "5372",
	"credentialFields[1].isOptionalMFA": 0,
	"credentialFields[1].isMFA": 0
}',
            'response' => '{
    "siteAccountId": 10023463,
    "isCustom": false,
    "credentialsChangedTime": 1403248116,
    "siteRefreshInfo": {
        "siteRefreshStatus": {
            "siteRefreshStatusId": 1,
            "siteRefreshStatus": "REFRESH_TRIGGERED"
        },
        "siteRefreshMode": {
            "refreshModeId": 1,
            "refreshMode": "MFA"
        },
        "updateInitTime": 1403785542,
        "nextUpdate": 1403786442,
        "code": 0,
        "suggestedFlow": {
            "suggestedFlowId": 2,
            "suggestedFlow": "REFRESH"
        },
        "itemRefreshInfo": [
            {
                "memItemId": 10035108,
                "itemSuggestedFlow": {
                    "suggestedFlowId": 2,
                    "suggestedFlow": "REFRESH"
                },
                "errorCode": 0,
                "retryCount": 0
            },
            {
                "memItemId": 10035109,
                "itemSuggestedFlow": {
                    "suggestedFlowId": 2,
                    "suggestedFlow": "REFRESH"
                },
                "errorCode": 0,
                "retryCount": 0
            }
        ],
        "noOfRetry": 0
    },
    "siteInfo": {
        "popularity": 0,
        "siteId": 2852,
        "orgId": 1120,
        "defaultDisplayName": "Bank of America",
        "defaultOrgDisplayName": "Bank of America",
        "enabledContainers": [
            {
                "containerName": "bank",
                "assetType": 1
            },
            {
                "containerName": "bill_payment",
                "assetType": 0
            },
            {
                "containerName": "credits",
                "assetType": 2
            },
            {
                "containerName": "loans",
                "assetType": 2
            },
            {
                "containerName": "mortgage",
                "assetType": 2
            }
        ],
        "baseUrl": "http://www.bankofamerica.com/",
        "loginForms": [],
        "isHeld": false,
        "isCustom": false,
        "mfaType": {
            "typeId": 4,
            "typeName": "SECURITY_QUESTION"
        },
        "siteSearchVisibility": true
    },
    "created": "2014-06-20T00:08:36-0700",
    "retryCount": 0
}',
        ),
        'description' => 'Adds a bank account of user on accessing the credentials filled in the prescribed format of data which is got through GetSiteLoginForm service',
    ),
    'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
        'POST' => array(
            'description' => 'This REST API provides the login form associated with the requested site. The login form comprises of the credential fields that are required for adding a member to that site. This call lets the consumers enter their credentials into the login form for the site they are trying to add.

For further info please yodlee documentation at 
https://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/Aggregation_REST_API_Reference/getSiteLoginForm',
            'request' => '{
   "site_id": "Site id is bank id as identified by yodlee", // ex: 2852
   "customer_id": "Customer Id"
}',
            'response' => '{
    "conjunctionOp": {
        "conjuctionOp": 1
    },
    "componentList": [
        {
            "valueIdentifier": "LOGIN",
            "valueMask": "LOGIN_FIELD",
            "fieldType": {
                "typeName": "IF_LOGIN"
            },
            "size": 20,
            "maxlength": 40,
            "name": "LOGIN",
            "displayName": "Online ID",
            "isEditable": true,
            "isOptional": false,
            "isEscaped": false,
            "helpText": "5371",
            "isOptionalMFA": false,
            "isMFA": false
        },
        {
            "valueIdentifier": "PASSWORD",
            "valueMask": "LOGIN_FIELD",
            "fieldType": {
                "typeName": "IF_PASSWORD"
            },
            "size": 20,
            "maxlength": 20,
            "name": "PASSWORD",
            "displayName": "Passcode",
            "isEditable": true,
            "isOptional": false,
            "isEscaped": false,
            "helpText": "5372",
            "isOptionalMFA": false,
            "isMFA": false
        }
    ],
    "defaultHelpText": "2152"
}',
        ),
        'description' => 'Retrieves the given site id login form.',
    ),
    'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => array(
        'GET' => array(
            'description' => 'Searches and retrieves banks available in yodlee api based on the given search string.',
            'request' => null,
            'response' => '[
    {
        "popularity": 0,
        "siteId": 2852,
        "orgId": 1120,
        "defaultDisplayName": "Bank of America",
        "defaultOrgDisplayName": "Bank of America",
        "contentServiceInfos": [
            {
                "contentServiceId": 2931,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "bank",
                    "assetType": 1
                }
            },
            {
                "contentServiceId": 9733,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "bill_payment",
                    "assetType": 0
                }
            },
            {
                "contentServiceId": 12847,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "credits",
                    "assetType": 2
                }
            },
            {
                "contentServiceId": 4249,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "loans",
                    "assetType": 2
                }
            },
            {
                "contentServiceId": 12848,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "mortgage",
                    "assetType": 2
                }
            }
        ],
        "enabledContainers": [
            {
                "containerName": "bank",
                "assetType": 1
            },
            {
                "containerName": "bill_payment",
                "assetType": 0
            },
            {
                "containerName": "credits",
                "assetType": 2
            },
            {
                "containerName": "loans",
                "assetType": 2
            },
            {
                "containerName": "mortgage",
                "assetType": 2
            }
        ],
        "baseUrl": "http://www.bankofamerica.com/",
        "loginForms": [
            {
                "conjunctionOp": {
                    "conjuctionOp": 1
                },
                "componentList": [
                    {
                        "valueIdentifier": "LOGIN",
                        "valueMask": "LOGIN_FIELD",
                        "fieldType": {
                            "typeName": "IF_LOGIN"
                        },
                        "size": 20,
                        "maxlength": 40,
                        "name": "LOGIN",
                        "displayName": "Online ID",
                        "isEditable": true,
                        "isOptional": false,
                        "isEscaped": false,
                        "helpText": "5371",
                        "isOptionalMFA": false,
                        "isMFA": false
                    },
                    {
                        "valueIdentifier": "PASSWORD",
                        "valueMask": "LOGIN_FIELD",
                        "fieldType": {
                            "typeName": "IF_PASSWORD"
                        },
                        "size": 20,
                        "maxlength": 20,
                        "name": "PASSWORD",
                        "displayName": "Passcode",
                        "isEditable": true,
                        "isOptional": false,
                        "isEscaped": false,
                        "helpText": "5372",
                        "isOptionalMFA": false,
                        "isMFA": false
                    }
                ],
                "defaultHelpText": "2152"
            }
        ],
        "isHeld": false,
        "isCustom": false,
        "mfaType": {
            "typeId": 4,
            "typeName": "SECURITY_QUESTION"
        },
        "mfaCoverage": "FMPA",
        "siteSearchVisibility": true
    },
	{
		More data
	}
]',
        ),
        'description' => 'Searches and retrieves banks available in yodlee api based on the given search string.',
        'POST' => array(
            'description' => 'This REST API accepts the search string to search for sites. If the search string is found in the Display Name parameter or AKA parameter or Keywords parameter of any SiteInfo object, that site will be included in this array of matching sites.

Yodlee documentation can be found at https://developer.yodlee.com/Indy_FinApp/Aggregation_Services_Guide/Aggregation_REST_API_Reference/searchSite',
            'request' => '{
   "customer_id": "Customer Id",
   "search_string": ""
}',
            'response' => '[
    {
        "popularity": 0,
        "siteId": 2852,
        "orgId": 1120,
        "defaultDisplayName": "Bank of America",
        "defaultOrgDisplayName": "Bank of America",
        "contentServiceInfos": [
            {
                "contentServiceId": 2931,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "bank",
                    "assetType": 1
                }
            },
            {
                "contentServiceId": 9733,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "bill_payment",
                    "assetType": 0
                }
            },
            {
                "contentServiceId": 12847,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "credits",
                    "assetType": 2
                }
            },
            {
                "contentServiceId": 4249,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "loans",
                    "assetType": 2
                }
            },
            {
                "contentServiceId": 12848,
                "siteId": 2852,
                "containerInfo": {
                    "containerName": "mortgage",
                    "assetType": 2
                }
            }
        ],
        "enabledContainers": [
            {
                "containerName": "bank",
                "assetType": 1
            },
            {
                "containerName": "bill_payment",
                "assetType": 0
            },
            {
                "containerName": "credits",
                "assetType": 2
            },
            {
                "containerName": "loans",
                "assetType": 2
            },
            {
                "containerName": "mortgage",
                "assetType": 2
            }
        ],
        "baseUrl": "http://www.bankofamerica.com/",
        "loginForms": [
            {
                "conjunctionOp": {
                    "conjuctionOp": 1
                },
                "componentList": [
                    {
                        "valueIdentifier": "LOGIN",
                        "valueMask": "LOGIN_FIELD",
                        "fieldType": {
                            "typeName": "IF_LOGIN"
                        },
                        "size": 20,
                        "maxlength": 40,
                        "name": "LOGIN",
                        "displayName": "Online ID",
                        "isEditable": true,
                        "isOptional": false,
                        "isEscaped": false,
                        "helpText": "5371",
                        "isOptionalMFA": false,
                        "isMFA": false
                    },
                    {
                        "valueIdentifier": "PASSWORD",
                        "valueMask": "LOGIN_FIELD",
                        "fieldType": {
                            "typeName": "IF_PASSWORD"
                        },
                        "size": 20,
                        "maxlength": 20,
                        "name": "PASSWORD",
                        "displayName": "Passcode",
                        "isEditable": true,
                        "isOptional": false,
                        "isEscaped": false,
                        "helpText": "5372",
                        "isOptionalMFA": false,
                        "isMFA": false
                    }
                ],
                "defaultHelpText": "2152"
            }
        ],
        "isHeld": false,
        "isCustom": false,
        "mfaType": {
            "typeId": 4,
            "typeName": "SECURITY_QUESTION"
        },
        "mfaCoverage": "FMPA",
        "siteSearchVisibility": true
    },
    {
	  // more objects of similar kind
    }	  
]',
        ),
    ),
    'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
        'GET' => array(
            'description' => 'Fetches customer bank transactions based on given customer_id. optionally url parameters page and limit can be sent to get the pagination functionality. By default page=1 and limit=50 are taken if not passed the values.',
            'request' => null,
            'response' => '{
    "total": 5,
    "accounts": [
        {
            "siteId": "12",
            "memSiteAccId": "10024830",
            "containerName": "credits",
            "itemAccountId": "10047607",
            "transactionId": "10538573",
            "accountName": "Costco TrueEarnings Card",
            "accountNumber": "XXXXXXXXXXXX1005",
            "containerType": "credits",
            "postDate": "2014-07-01 07:00:00",
            "description": "JUNGH YANG MD CLINICIRVINE xxxxxxxxx xxxxxxxx5108",
            "simpleDescription": "JUNGH YANG MD CLINICIRVINE xxxxxxxxx xxxxxxxx5108",
            "transactionType": "debit",
            "merchantName": "",
            "categoryId": "1",
            "categoryName": "Uncategorized",
            "amount": "110.00",
            "currencyCode": "USD"
        },
        {
            "siteId": "12",
            "memSiteAccId": "10024830",
            "containerName": "credits",
            "itemAccountId": "10047607",
            "transactionId": "10538578",
            "accountName": "Costco TrueEarnings Card",
            "accountNumber": "XXXXXXXXXXXX1005",
            "containerType": "credits",
            "postDate": "2014-06-30 07:00:00",
            "description": "COSTCO GAS #1001 000TUSTIN xxxxxxxxx xxxxxx1943",
            "simpleDescription": "Costco Gas",
            "transactionType": "debit",
            "merchantName": "Costco Gas",
            "categoryId": "8",
            "categoryName": "Gasoline/Fuel",
            "amount": "15.83",
            "currencyCode": "USD"
        },
        {
            "siteId": "12",
            "memSiteAccId": "10024830",
            "containerName": "credits",
            "itemAccountId": "10047607",
            "transactionId": "10538596",
            "accountName": "Costco TrueEarnings Card",
            "accountNumber": "XXXXXXXXXXXX1005",
            "containerType": "credits",
            "postDate": "2014-06-30 07:00:00",
            "description": "COSTCO WHSE #1001 00TUSTIN xxxxxxxxx xxxxxx1935",
            "simpleDescription": "Costco Wholesale",
            "transactionType": "debit",
            "merchantName": "Costco Wholesale",
            "categoryId": "44",
            "categoryName": "General Merchandise",
            "amount": "66.20",
            "currencyCode": "USD"
        },
        {
            "siteId": "2852",
            "memSiteAccId": "10023463",
            "containerName": "bank",
            "itemAccountId": "10045103",
            "transactionId": "10792274",
            "accountName": "Bank of America Core Checking-8600",
            "accountNumber": "XXXXXXXXXXXX8600",
            "containerType": "bank",
            "postDate": "2014-06-30 07:00:00",
            "description": "Online Banking Transfer Conf# d67sis64l; POURVASEI, ALI",
            "simpleDescription": "Transfer",
            "transactionType": "credit",
            "merchantName": "Transfer",
            "categoryId": "28",
            "categoryName": "Transfers",
            "amount": "7985.00",
            "currencyCode": "USD"
        },
        {
            "siteId": "12",
            "memSiteAccId": "10024830",
            "containerName": "credits",
            "itemAccountId": "10047607",
            "transactionId": "10538576",
            "accountName": "Costco TrueEarnings Card",
            "accountNumber": "XXXXXXXXXXXX1005",
            "containerType": "credits",
            "postDate": "2014-06-29 07:00:00",
            "description": "COSTCO GAS #1001 000TUSTIN xxxxxxxxx xxxxxx1943",
            "simpleDescription": "Costco Gas",
            "transactionType": "debit",
            "merchantName": "Costco Gas",
            "categoryId": "8",
            "categoryName": "Gasoline/Fuel",
            "amount": "53.14",
            "currencyCode": "USD"
        }
    ]
}',
        ),
        'description' => 'Fetches customer bank transactions based on given customer_id. optionally url parameters page and limit can be sent to get the pagination functionality. By default page=1 and limit=50 are taken if not passed the values.',
    ),
    'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
        'GET' => array(
            'description' => 'Retrieves the list of accounts added to privypass system by a customer',
            'request' => null,
            'response' => '{
    "result": "success",
    "total": 5,
    "accounts": [
        {
            "siteId": "2852",
            "memSiteAccId": "10023463",
            "containerName": "bank",
            "itemDisplayName": "Bank of America - Bank",
            "itemAccountId": "10045103",
            "itemId": "10035108",
            "accountId": "10035005",
            "baseTagDataId": "BANK_ACCOUNT:10035108:0:10035005",
            "accountType": "bank",
            "accountName": "Bank of America Core Checkingx8600",
            "accountHolder": "LAKSHMI M KODALI",
            "accountNumber": "XXXXXXXXXXXX8600",
            "runningBalance": "0.00",
            "lastPayment": "0.00",
            "availableCredit": "0.00",
            "availableCash": "0.00",
            "totalCreditLine": "0.00",
            "totalCashLimit": "0.00",
            "availableBalance": "7812.62",
            "currentBalance": "8592.62"
        },
        {
            "siteId": "2852",
            "memSiteAccId": "10023463",
            "containerName": "credits",
            "itemDisplayName": "Bank of America - Credit Card",
            "itemAccountId": "10045104",
            "itemId": "10035109",
            "accountId": "10015337",
            "baseTagDataId": "CARD_ACCOUNT:10035109:0:10015337",
            "accountType": "credits",
            "accountName": "BankAmericard",
            "accountHolder": "LAKSHMI M KODALI",
            "accountNumber": "XXXXXXXXXXXX9928",
            "runningBalance": "8168.10",
            "lastPayment": "50.00",
            "availableCredit": "0.00",
            "availableCash": "0.00",
            "totalCreditLine": "7500.00",
            "totalCashLimit": "2250.00",
            "availableBalance": "0.00",
            "currentBalance": "0.00"
        },
        {
            "siteId": "11",
            "memSiteAccId": "10023464",
            "containerName": "credits",
            "itemDisplayName": "Discover Card",
            "itemAccountId": "10044983",
            "itemId": "10035352",
            "accountId": "10015428",
            "baseTagDataId": "CARD_ACCOUNT:10035352:0:10015428",
            "accountType": "credits",
            "accountName": "Discover",
            "accountHolder": "LAKSHMI M KODALI",
            "accountNumber": "XXXXXXXXXXXX0017",
            "runningBalance": "10760.11",
            "lastPayment": "0.00",
            "availableCredit": "2439.00",
            "availableCash": "0.00",
            "totalCreditLine": "13200.00",
            "totalCashLimit": "0.00",
            "availableBalance": "0.00",
            "currentBalance": "0.00"
        },
        {
            "siteId": "11",
            "memSiteAccId": "10023464",
            "containerName": "miles",
            "itemDisplayName": "Discover Card - Rewards",
            "itemAccountId": "10044984",
            "itemId": "10035353",
            "accountId": "10007300",
            "baseTagDataId": "REWARD_PGM:10035353:0:10007300",
            "accountType": "miles",
            "accountName": null,
            "accountHolder": null,
            "accountNumber": "XXXXXXXXXXXX0017",
            "runningBalance": "0.00",
            "lastPayment": "0.00",
            "availableCredit": "0.00",
            "availableCash": "0.00",
            "totalCreditLine": "0.00",
            "totalCashLimit": "0.00",
            "availableBalance": "0.00",
            "currentBalance": "0.00"
        },
        {
            "siteId": "12",
            "memSiteAccId": "10024830",
            "containerName": "credits",
            "itemDisplayName": "American Express Cards",
            "itemAccountId": "10047607",
            "itemId": "10037624",
            "accountId": "10016990",
            "baseTagDataId": "CARD_ACCOUNT:10037624:0:10016990",
            "accountType": "credits",
            "accountName": "Costco TrueEarnings Card",
            "accountHolder": "VEERAMALLA LINGENDRA",
            "accountNumber": "XXXXXXXXXXXX1005",
            "runningBalance": "1974.35",
            "lastPayment": "1831.62",
            "availableCredit": "7030.00",
            "availableCash": "400.00",
            "totalCreditLine": "9200.00",
            "totalCashLimit": "400.00",
            "availableBalance": "0.00",
            "currentBalance": "0.00"
        }
    ]
}',
        ),
        'description' => 'Retrieves the list of bank accounts added by a customer',
    ),
    'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
        'POST' => array(
            'description' => 'Updates yodlee with multi factor authentication related qustions and answers. During add Site account if the response is of mfa type, then it contains mfa object with questions to be answered like below.

{
  "result": "mfa",
  "mfa": {
   "isMessageAvailable":true,
   "fieldInfo":{
      "questionAndAnswerValues":[
         {
            "question":"What is the name of your state?",
            "questionFieldType":"label",
            "responseFieldType":"text",
            "isRequired":"true",
            "sequence":1,
            "metaData":"QUESTION_1"
         },
         {
            "question":"What is the name of your first school",
            "questionFieldType":"label",
            "responseFieldType":"text",
            "isRequired":"true",
            "sequence":2,
            "metaData":"QUESTION_2"
         }
      ],
      "numOfMandatoryQuestions":-1
   },
   "timeOutTime":84250,
   "itemId":0,
   "memSiteAccId":10283454,
   "retry":false
  }
}

Then the post data should be sent as follows

{
  "cusotmer_id" : "100000000001",
  "memSiteAccId": "123456",
  "userResponse.quesAnsDetailArray[0].answer=Texas"
  "userResponse.quesAnsDetailArray[0].answerFieldType": "text"
  "userResponse.quesAnsDetailArray[0].metaData": "QUESTION_1"
  "userResponse.quesAnsDetailArray[0].question": "What is the name of your state?"
  "userResponse.quesAnsDetailArray[0].questionFieldType": "label"
  "userResponse.quesAnsDetailArray[1].answer": "w3schools"
  "userResponse.quesAnsDetailArray[1].answerFieldType": "text"
  "userResponse.quesAnsDetailArray[1].metaData": "QUESTION_2"
  "userResponse.quesAnsDetailArray[1].question": "What is the name of your first school"
  "userResponse.quesAnsDetailArray[1].questionFieldType": "label"
}',
            'request' => '{
  "cusotmer_id" : "100000000001",
  "memSiteAccId": "123456",
  "userResponse.quesAnsDetailArray[0].answer=Texas"
  "userResponse.quesAnsDetailArray[0].answerFieldType": "text"
  "userResponse.quesAnsDetailArray[0].metaData": "QUESTION_1"
  "userResponse.quesAnsDetailArray[0].question": "What is the name of your state?"
  "userResponse.quesAnsDetailArray[0].questionFieldType": "label"
  "userResponse.quesAnsDetailArray[1].answer": "w3schools"
  "userResponse.quesAnsDetailArray[1].answerFieldType": "text"
  "userResponse.quesAnsDetailArray[1].metaData": "QUESTION_2"
  "userResponse.quesAnsDetailArray[1].question": "What is the name of your first school"
  "userResponse.quesAnsDetailArray[1].questionFieldType": "label"
}',
            'response' => null,
        ),
    ),
    'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => array(
        'GET' => array(
            'description' => null,
            'request' => null,
            'response' => '{
    "count": 11,
    "banks": [
        {
            "siteId": "5",
            "bankName": "Wells Fargo"
        },
        {
            "siteId": "11",
            "bankName": "Discover Card"
        },
        {
            "siteId": "12",
            "bankName": "American Express Cards"
        },
        {
            "siteId": "39",
            "bankName": "Chase Bank"
        },
        {
            "siteId": "70",
            "bankName": "Janus"
        },
        {
            "siteId": "87",
            "bankName": "DWS Investments"
        },
        {
            "siteId": "111",
            "bankName": "US Airways - Dividend Miles"
        },
        {
            "siteId": "423",
            "bankName": "Midwest Express Frequent Flyer"
        },
        {
            "siteId": "439",
            "bankName": "USE Credit Union (CA)"
        },
        {
            "siteId": "457",
            "bankName": "Putnam Investments (Individual Investors)"
        },
        {
            "siteId": "459",
            "bankName": "Union Bank"
        }
}',
        ),
        'description' => 'Responds with list of banks with SiteId and Name',
    ),
);
