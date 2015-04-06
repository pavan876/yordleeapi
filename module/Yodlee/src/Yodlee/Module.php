<?php
namespace Yodlee;

use ZF\Apigility\Provider\ApigilityProviderInterface;
use Zend\EventManager\EventInterface as Event;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            //            'factories' => array(
            //                'YodleeBroker' => function ($sm) {
            //                        return new \Yodlee\V1\Model\YodleeBroker($sm);
            //                    },
            //            ),
        );
    }

    public function onBootstrap(Event $e)
    {
        if (!defined('YODLEE_AGENCY_ID')) {
            define('YODLEE_AGENCY_ID', 1);
        }
        if (!defined('BANK_AGENCY_CREDENTIALS_ID')) {
            define('BANK_AGENCY_CREDENTIALS_ID', 1);
        }
        if (!defined('YODLEE_ENCRYPT_KEY')) {
            define('YODLEE_ENCRYPT_KEY', 'A0509D976FAB0C12F5411AA2535B9694E516AA13');
        }
    }
}
