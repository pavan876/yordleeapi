<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => 'Intuit\\V1\\Rpc\\BankSearch\\BankSearchControllerFactory',
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => 'Intuit\\V1\\Rpc\\RefreshBankList\\RefreshBankListControllerFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'intuit.rpc.bank-search',
            1 => 'intuit.rpc.refresh-bank-list',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Intuit\\V1\\Rpc\\BankSearch\\Controller' => 'Json',
            'Intuit\\V1\\Rpc\\RefreshBankList\\Controller' => 'Json',
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
