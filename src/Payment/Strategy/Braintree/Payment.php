<?php

namespace Payment\Strategy\Braintree;

use Payment\Interfaces\PaymentStrategy;
use Payment\Model\CardTypeDetect;

/**
 * Paypal payment
 * @copyright Copyright (c) 2015
 * @author    Surapun Prasit
 * @package   Payment
 */
class Payment implements PaymentStrategy
{
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::getPaymentName()
     */
    public function getPaymentName () {
        return 'braintree';
    }

    /**
     * Set zend service locator
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * get api configuration
     */
    public function getApiConfig ()
    {
        $config = $this->serviceLocator->get('config');

        if (isset($config['payment']['braintree']['api'])) {
            return $config['payment']['braintree']['api'];
        }

        return false;
    }


    /**
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::selectPayment()
     */
    public function selectPayment($cardInfomation)
    {
        $typeDetector = new CardTypeDetect();

        // if credit card type is AMEX, then use Paypal.
        if (isset($cardInfomation['number']) &&
                $typeDetector->detect($cardInfomation['number']) == 'AMEX') {
            return false;
        }

        return true;
    }
}