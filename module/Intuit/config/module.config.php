<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => 'Intuit\\V1\\Rpc\\BankSearch\\BankSearchControllerFactory',
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => 'Intuit\\V1\\Rpc\\RefreshBankList\\RefreshBankListControllerFactory',
            'Intuit\\V1\\Rpc\\GetBankList\\Controller' => 'Intuit\\V1\\Rpc\\GetBankList\\GetBankListControllerFactory',
            'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => 'Intuit\\V1\\Rpc\\GetSiteLoginForm\\GetSiteLoginFormControllerFactory',
            'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => 'Intuit\\V1\\Rpc\\AddSiteAccount\\AddSiteAccountControllerFactory',
            'Intuit\\V1\\Rpc\\RemoveSiteAccount\\Controller' => 'Intuit\\V1\\Rpc\\RemoveSiteAccount\\RemoveSiteAccountControllerFactory',
            'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => 'Intuit\\V1\\Rpc\\RemoveCustomer\\RemoveCustomerControllerFactory',
            'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => 'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\FetchTransactionByAccountControllerFactory',
            'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => 'Intuit\\V1\\Rpc\\MFARequestForSite\\MFARequestForSiteControllerFactory',
            'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => 'Intuit\\V1\\Rpc\\GetBankAccounts\\GetBankAccountsControllerFactory',
            'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => 'Intuit\\V1\\Rpc\\GetCustomerTransactions\\GetCustomerTransactionsControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'intuit.rpc.bank-search' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/search-banks',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\BankSearch\\Controller',
                        'action' => 'bankSearch',
                    ),
                ),
            ),
            'intuit.rpc.refresh-bank-list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/refresh-bank-list',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\RefreshBankList\\Controller',
                        'action' => 'refreshBankList',
                    ),
                ),
            ),
            'intuit.rpc.get-bank-list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/get-bank-list',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\GetBankList\\Controller',
                        'action' => 'getBankList',
                    ),
                ),
            ),
            'intuit.rpc.get-site-login-form' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/get-site-login-form',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller',
                        'action' => 'getSiteLoginForm',
                    ),
                ),
            ),
            'intuit.rpc.add-site-account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/add-site-account',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller',
                        'action' => 'addSiteAccount',
                    ),
                ),
            ),
            'intuit.rpc.remove-customer' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/remove-customer',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller',
                        'action' => 'removeCustomer',
                    ),
                ),
            ),
            'intuit.rpc.fetch-transaction-by-account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/fetch-transactions-by-account/:customer_id/:account_id',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller',
                        'action' => 'fetchTransactionByAccount',
                    ),
                ),
            ),
            'intuit.rpc.mfa-request-for-site' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/mfa-request-for-site',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller',
                        'action' => 'mFARequestForSite',
                    ),
                ),
            ),
            'intuit.rpc.get-bank-accounts' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/get-bank-accounts/:customer_id',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller',
                        'action' => 'getBankAccounts',
                    ),
                ),
            ),
            'intuit.rpc.get-customer-transactions' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/intuit/get-customer-transactions/:customer_id',
                    'defaults' => array(
                        'controller' => 'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller',
                        'action' => 'getCustomerTransactions',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'intuit.rpc.bank-search',
            1 => 'intuit.rpc.refresh-bank-list',
            2 => 'intuit.rpc.get-bank-list',
            3 => 'intuit.rpc.get-site-login-form',
            4 => 'intuit.rpc.add-site-account',
            5 => 'intuit.rpc.remove-customer',
            6 => 'intuit.rpc.fetch-transaction-by-account',
            7 => 'intuit.rpc.mfa-request-for-site',
            8 => 'intuit.rpc.get-bank-accounts',
            9 => 'intuit.rpc.get-customer-transactions',
        ),
    ),
    'zf-rpc' => array(
        'Intuit\\V1\\Rpc\\BankSearch\\Controller' => array(
            'service_name' => 'BankSearch',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.bank-search',
        ),
        'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => array(
            'service_name' => 'RefreshBankList',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.refresh-bank-list',
        ),
        'Intuit\\V1\\Rpc\\GetBankList\\Controller' => array(
            'service_name' => 'GetBankList',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'intuit.rpc.get-bank-list',
        ),
        'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
            'service_name' => 'GetSiteLoginForm',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.get-site-login-form',
        ),
        'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
            'service_name' => 'AddSiteAccount',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.add-site-account',
        ),
        'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => array(
            'service_name' => 'RemoveCustomer',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.remove-customer',
        ),
        'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => array(
            'service_name' => 'FetchTransactionByAccount',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'intuit.rpc.fetch-transaction-by-account',
        ),
        'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
            'service_name' => 'MFARequestForSite',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'intuit.rpc.mfa-request-for-site',
        ),
        'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
            'service_name' => 'GetBankAccounts',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'intuit.rpc.get-bank-accounts',
        ),
        'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
            'service_name' => 'GetCustomerTransactions',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'intuit.rpc.get-customer-transactions',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\GetBankList\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\RemoveSiteAccount\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\GetBankList\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\RemoveSiteAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\GetBankList\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\GetSiteLoginForm\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\AddSiteAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\RemoveSiteAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\RemoveCustomer\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\FetchTransactionByAccount\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\MFARequestForSite\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\GetBankAccounts\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
            'Intuit\\V1\\Rpc\\GetCustomerTransactions\\Controller' => array(
                0 => 'application/vnd.intuit.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Intuit\\V1\\Rpc\\BankSearch\\Controller' => array(
            'input_filter' => 'Intuit\\V1\\Rpc\\BankSearch\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Intuit\\V1\\Rpc\\BankSearch\\Validator' => array(
            0 => array(
                'name' => 'customer_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            1 => array(
                'name' => 'search_string',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
        ),
    ),
);
