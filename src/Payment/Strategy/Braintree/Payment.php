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
     * @var unknown
     */
    protected $payment;

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

    /**
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::getPaymentId()
     */
    public function getPaymentId()
    {
        if (!$this->payment) {
            throw new \Exception ('Payment has not been created');
        }

        return $this->payment->transaction->_attributes['id'];
    }

    /**
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::getPaymentState()
     */
    public function getPaymentState()
    {
        if (!$this->payment) {
            throw new \Exception ('Payment has not been created');
        }
        return $this->payment->transaction->status;
    }

    /**
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::pay()
     */
    public function pay($info)
    {
        $config = $this->getApiConfig();

        \Braintree_Configuration::environment('sandbox');
        \Braintree_Configuration::merchantId($config['merchantId']);
        \Braintree_Configuration::publicKey($config['publicKey']);
        \Braintree_Configuration::privateKey($config['privateKey']);


        $this->payment = \Braintree_Transaction::sale(array(
                'amount' => $info['price'],
//                 'customer' => array(
//                         'firstName'    => !empty($info['firstname']) ? $info['firstname'] : false,
//                         'lastName'    => !empty($info['lastName']) ? $info['lastName'] : false
//                 ),
                'creditCard' => array(
                        'number' => $info['number'],
                        'expirationMonth' => $info['expiredMonth'],
                        'expirationYear' => $info['expiredYear']
                )
        ));

        return $this->payment->success ? true : false;
    }
}