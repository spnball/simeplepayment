<?php
namespace Payment;

/**
 * @copyright Copyright (c) 2012
 * @author    Surapun Prasit
 * @package   EasyRest
 */
class Module {
    /**
     * Get Auto loader configuration
     *
     * @return Configuration
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // Module namespace
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,

                    // UnitTesting namespace
                    __NAMESPACE__ . 'Test' => __DIR__ . '/PHPUnit/' . __NAMESPACE__,

                    // Paypal SDK library namespace path
                    'PayPal'  => __DIR__ . '/src/' . __NAMESPACE__ . '/Strategy/Paypal/sdk/lib/PayPal'
                ),
            ),
        );
    }

    /**
     * Get configuration
     *
     * @return Configuration
     */
    public function getConfig()
    {
        return array_merge(
                include __DIR__ . '/config/route.php',
                include __DIR__ . '/config/interface.php',
                include __DIR__ . '/config/services.php',
                include __DIR__ . '/config/payment.php'
        );
    }
}
