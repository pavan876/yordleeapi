<?php
namespace Intuit;

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

    public function onBootstrap(Event $e)
    {
        if (!defined('INTUIT_AGENCY_ID')) {
            define('INTUIT_AGENCY_ID', 2);
        }
    }
}
