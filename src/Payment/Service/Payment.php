<?php
namespace Payment\Service;

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
                return $payment;
            }
        }

        return false;
    }
}
