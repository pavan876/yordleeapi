<?php
return array(
    'router' => array(
        'routes' => array(
            'yodlee.rpc.bank-search' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/search-banks',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\BankSearch\\Controller',
                        'action' => 'bankSearch',
                    ),
                ),
            ),
            'yodlee.rpc.get-site-login-form' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/get-site-login-form',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller',
                        'action' => 'getSiteLoginForm',
                    ),
                ),
            ),
            'yodlee.rpc.add-site-account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/add-site-account',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller',
                        'action' => 'addSiteAccount',
                    ),
                ),
            ),
            'yodlee.rpc.fetch-bank-transactions' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/fetch-bank-transactions/:customer_id',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller',
                        'action' => 'fetchBankTransactions',
                    ),
                ),
            ),
            'yodlee.rpc.get-bank-accounts' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/get-bank-accounts/:customer_id',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller',
                        'action' => 'getBankAccounts',
                    ),
                ),
            ),
            'yodlee.rpc.get-customer-transactions' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/get-customer-transactions/:customer_id',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller',
                        'action' => 'getCustomerTransactions',
                    ),
                ),
            ),
            'yodlee.rpc.instant-account-verification' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/iav',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller',
                        'action' => 'instantAccountVerification',
                    ),
                ),
            ),
            'yodlee.rpc.mfa-request-for-site' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/mfa-request-for-site',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller',
                        'action' => 'mFARequestForSite',
                    ),
                ),
            ),
            'yodlee.rpc.fetch-transactions-by-account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/fetch-transactions-by-account/:mem_site_account_id',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller',
                        'action' => 'fetchTransactionsByAccount',
                    ),
                ),
            ),
            'yodlee.rpc.get-bank-list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/get-bank-list',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\GetBankList\\Controller',
                        'action' => 'getBankList',
                    ),
                ),
            ),
            'yodlee.rpc.get-formatted-login-form' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/yodlee/formattted-login-form/:site_id',
                    'defaults' => array(
                        'controller' => 'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller',
                        'action' => 'getFormattedLoginForm',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'yodlee.rpc.bank-search',
            1 => 'yodlee.rpc.get-site-login-form',
            2 => 'yodlee.rpc.add-site-account',
            3 => 'yodlee.rpc.fetch-bank-transactions',
            4 => 'yodlee.rpc.get-bank-accounts',
            5 => 'yodlee.rpc.get-customer-transactions',
            6 => 'yodlee.rpc.instant-account-verification',
            7 => 'yodlee.rpc.mfa-request-for-site',
            9 => 'yodlee.rpc.fetch-transactions-by-account',
            11 => 'yodlee.rpc.get-bank-list',
            12 => 'yodlee.rpc.get-formatted-login-form',
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => 'Json',
            'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
            'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller' => array(
                0 => 'application/vnd.yodlee.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(),
    ),
    'controllers' => array(
        'factories' => array(
            'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => 'Yodlee\\V1\\Rpc\\BankSearch\\BankSearchControllerFactory',
            'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => 'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\GetSiteLoginFormControllerFactory',
            'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => 'Yodlee\\V1\\Rpc\\AddSiteAccount\\AddSiteAccountControllerFactory',
            'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller' => 'Yodlee\\V1\\Rpc\\FetchBankTransactions\\FetchBankTransactionsControllerFactory',
            'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => 'Yodlee\\V1\\Rpc\\GetBankAccounts\\GetBankAccountsControllerFactory',
            'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => 'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\GetCustomerTransactionsControllerFactory',
            'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller' => 'Yodlee\\V1\\Rpc\\InstantAccountVerification\\InstantAccountVerificationControllerFactory',
            'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => 'Yodlee\\V1\\Rpc\\MFARequestForSite\\MFARequestForSiteControllerFactory',
            'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller' => 'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\FetchTransactionsByAccountControllerFactory',
            'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => 'Yodlee\\V1\\Rpc\\GetBankList\\GetBankListControllerFactory',
            'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller' => 'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\GetFormattedLoginFormControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => array(
            'service_name' => 'BankSearch',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'yodlee.rpc.bank-search',
        ),
        'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
            'service_name' => 'GetSiteLoginForm',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'yodlee.rpc.get-site-login-form',
        ),
        'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
            'service_name' => 'AddSiteAccount',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'yodlee.rpc.add-site-account',
        ),
        'Yodlee\\V1\\Rpc\\FetchBankTransactions\\Controller' => array(
            'service_name' => 'FetchBankTransactions',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.fetch-bank-transactions',
        ),
        'Yodlee\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
            'service_name' => 'GetBankAccounts',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.get-bank-accounts',
        ),
        'Yodlee\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
            'service_name' => 'GetCustomerTransactions',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.get-customer-transactions',
        ),
        'Yodlee\\V1\\Rpc\\InstantAccountVerification\\Controller' => array(
            'service_name' => 'InstantAccountVerification',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.instant-account-verification',
        ),
        'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
            'service_name' => 'MFARequestForSite',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'yodlee.rpc.mfa-request-for-site',
        ),
        'Yodlee\\V1\\Rpc\\FetchTransactionsByAccount\\Controller' => array(
            'service_name' => 'FetchTransactionsByAccount',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.fetch-transactions-by-account',
        ),
        'Yodlee\\V1\\Rpc\\GetBankList\\Controller' => array(
            'service_name' => 'GetBankList',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.get-bank-list',
        ),
        'Yodlee\\V1\\Rpc\\GetFormattedLoginForm\\Controller' => array(
            'service_name' => 'GetFormattedLoginForm',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'yodlee.rpc.get-formatted-login-form',
        ),
    ),
    'zf-content-validation' => array(
        'Yodlee\\V1\\Rpc\\BankSearch\\Controller' => array(
            'input_filter' => 'Yodlee\\V1\\Rpc\\BankSearch\\Validator',
        ),
        'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
            'input_filter' => 'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Validator',
        ),
        'Yodlee\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
            'input_filter' => 'Yodlee\\V1\\Rpc\\AddSiteAccount\\Validator',
        ),
        'Yodlee\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
            'input_filter' => 'Yodlee\\V1\\Rpc\\MFARequestForSite\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Yodlee\\V1\\Rpc\\BankSearch\\Validator' => array(
            0 => array(
                'name' => 'customer_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'description' => 'Customer Id',
            ),
            1 => array(
                'name' => 'search_string',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
        'Yodlee\\V1\\Rpc\\GetSiteLoginForm\\Validator' => array(
            0 => array(
                'name' => 'site_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Site id is bank id as identified by yodlee',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
        ),
        'Yodlee\\V1\\Rpc\\AddSiteAccount\\Validator' => array(
            0 => array(
                'name' => 'customer_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'Customer Id',
            ),
            1 => array(
                'name' => 'siteId',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'Unique Bank Id with in with respect to yodlee api.',
            ),
            2 => array(
                'name' => 'credentialFields.enclosedType',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the type of credentialFields. The values could be com.yodlee.common.FieldInfoMultiFixed
(which encapsulates a name-value pair setting for a multi-valued field, where the multiple values assumed are a fixed number) or com.yodlee.common.FieldInfoSingle (which encapsulates a name-value pair setting for a single valued field).',
            ),
            3 => array(
                'name' => 'credentialFields[0].displayName',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the name displayed for the field.',
            ),
            4 => array(
                'name' => 'credentialFields[0].fieldType.typeName',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the type of the field. The possible values are TEXT, IF_PASSWORD, OPTIONS, CHECKBOX, RADIO, IF_LOGIN, URL, HIDDEN, IMAGE_URL, CONTENT_URL, CUSTOM and CLUDGE.',
            ),
            5 => array(
                'name' => 'credentialFields[0].name',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the internal name of the field.',
            ),
            6 => array(
                'name' => 'credentialFields[0].value',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the value for the field.',
            ),
            7 => array(
                'name' => 'credentialFields[0].valueIdentifier',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the value identifier that uniquely identifies the field.',
            ),
            8 => array(
                'name' => 'credentialFields[0].valueMask',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the display mask to be set for the value of this field.',
            ),
            9 => array(
                'name' => 'credentialFields[0].isEditable',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This indicates whether the value is editable for this field.',
            ),
            10 => array(
                'name' => 'credentialFields[1].displayName',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the name displayed for the field.',
            ),
            11 => array(
                'name' => 'credentialFields[1].fieldType.typeName',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the type of the field. The possible values are TEXT, IF_PASSWORD, OPTIONS, CHECKBOX, RADIO, IF_LOGIN, URL, HIDDEN, IMAGE_URL, CONTENT_URL, CUSTOM and CLUDGE.',
            ),
            12 => array(
                'name' => 'credentialFields[1].name',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the internal name of the field.',
            ),
            13 => array(
                'name' => 'credentialFields[1].value',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the value for the field.',
            ),
            14 => array(
                'name' => 'credentialFields[1].valueIdentifier',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the value identifier that uniquely identifies the field.',
            ),
            15 => array(
                'name' => 'credentialFields[1].valueMask',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This is the display mask to be set for the value of this field.',
            ),
            16 => array(
                'name' => 'credentialFields[1].isEditable',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'allow_empty' => false,
                'continue_if_empty' => false,
                'description' => 'This indicates whether the value is editable for this field.',
            ),
        ),
        'Yodlee\\V1\\Rpc\\MFARequestForSite\\Validator' => array(
            0 => array(
                'name' => 'customer_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'description' => 'ID of the customer',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'memSiteAccId',
                'required' => true,
                'filters' => array(),
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\I18n\\Validator\\Int',
                        'options' => array(),
                    ),
                ),
                'description' => 'memSiteAccId for which mfa refresh is done',
            ),
        ),
    ),
);
