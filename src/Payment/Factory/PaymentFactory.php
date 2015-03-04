<?php
namespace Payment\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Payment\Service\Payment;

/**
 * Payment service factory
 * @author Surapun Prasit
 */
class PaymentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $payment =  new Payment();
        $payment->setServiceLocator($serviceLocator);

        return $payment;
    }
}