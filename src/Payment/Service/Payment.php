<?php
namespace Payment\Service;

use Payment\TableGateway\PaymentTable;
/**
 * Call the paying api
 * @copyright Copyright (c) 2014
 * @author    Surapun Prasit
 * @package   Payment
 */
class Payment  {
    /**
     * @var \Zend\ServiceManager\ServiceLocatorAwareInterface
     */
    protected $serviceLocator;

    /**
     * @var \Payment\Interfaces\PaymentStrategy
     */
    protected $payment;

    /**
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Get the payment strategy object
     * @param $creditcardInfo array
     * @return \Payment\Interfaces\PaymentStrategy|boolean
     */
    public function getPaymentStrategy ($creditcardInfo)
    {
        $config = $this->getServiceLocator()->get('config');
        foreach ($config['payment'] as $payment => $options) {
            if (!isset($options['strategy'])) {
                throw new \Exception('"'. $payment .'" payment strategy is not set');
            }

            $payment = new $options['strategy']();

            if ($payment->selectPayment($creditcardInfo) !== false) {
                $payment->setServiceLocator($this->serviceLocator);
                return $payment;
            }
        }

        return false;
    }

    /**
     * @param \Payment\Interfaces\PaymentStrategy $payment
     * @throws \Exception
     * @return \Payment\Service\Payment
     */
    public function save ($creditcardInfo, \Payment\Interfaces\PaymentStrategy $payment = null)
    {
        if ($payment === null) {
            if ($this->payment == null) {
                throw new \Exception('Invalid payment');
            }
            $payment = $this->payment;
        }

        $paymentTable = new PaymentTable();
        $paymentTable->setServiceLocator($this->serviceLocator);
        $paymentTable
            ->setPrice($creditcardInfo['price'])
            ->setCurrency($creditcardInfo['currency'])
            ->setFirstname($creditcardInfo['firstname'])
            ->setLastname($creditcardInfo['lastname'])
            ->setTransactionRef($payment->getPaymentId())
            ->setPaymentStrategy($payment->getPaymentName());

        $paymentTable->savePayment();
        return $this;
    }

    /**
     * @param unknown $creditcardInfo
     * @return boolean
     */
    public function pay ($creditcardInfo)
    {
        $this->payment = $this->getPaymentStrategy($creditcardInfo);

        if ($this->payment === false) {
            return false;
        }

        if ($this->payment->pay($creditcardInfo) === false) {
            return false;
        }

        $this->save($creditcardInfo);
        return true;
    }
}
