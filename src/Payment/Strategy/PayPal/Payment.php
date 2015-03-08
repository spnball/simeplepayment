<?php

namespace Payment\Strategy\PayPal;

use Payment\Interfaces\PaymentStrategy;
use Payment\Model\CardTypeDetect;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment as PayPalPayment;
use PayPal\Api\Payer;

/**
 * Paypal payment
 * @copyright Copyright (c) 2015
 * @author    Surapun Prasit
 * @package   Payment
 */
class Payment implements PaymentStrategy
{
    /**
     * @var OAuthTokenCredential
     */
    protected $token;

    /**
     * @var \PayPal\Api\Payment
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
    public function getPaymentName ()
    {
        return 'paypal';
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

        if (isset($config['payment']['paypal']['api'])) {
            return $config['payment']['paypal']['api'];
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
            if (isset($cardInfomation['currency']) && $cardInfomation['currency'] == 'USD' ) {
                return true;
            }

            return false;
        }

        // if currency is USD, EUR, or AUD, then use Paypal.
        if (isset($cardInfomation['currency'])) {
            switch (strtoupper($cardInfomation['currency'])) {
            	case 'USD' : case 'EUR' : case 'AUD' :
            	    return true;
            }
        }

        return false;
    }

    /**
     * get token key generator
     * @return \PayPal\Auth\OAuthTokenCredential
     */
    public function authen ()
    {
        $config = $this->getApiConfig();
        $this->token = new OAuthTokenCredential(
                $config['clientId'],
                $config['secret'],
                $config['sdk']
        );

        return $this->token;
    }

    /**
     * @return string
     */
    public function getPaymentId ()
    {
        if (!$this->payment) {
            throw new \Exception ('Payment has not been created');
        }

        return $this->payment->getId();
    }

    /**
     * @return string
     */
    public function getPaymentState ()
    {
        if (!$this->payment) {
            throw new \Exception ('Payment has not been created');
        }
        return $this->payment->getState();
    }

    public function message()
    {
        if (!$this->payment) {
            throw new \Exception ('Payment has not been created');
        }
        return $this->payment->getFailedTransactions()->getDetails();
    }

    /**
     * @param array $info
     * @return boolean
     */
    public function pay ($info)
    {
        $config = $this->getApiConfig();

        $apiContext = new ApiContext($this->authen(), 'Request' . time());
        $apiContext->setConfig($config['sdk']);

        $typeDetector = new CardTypeDetect();

        $card = new CreditCard();
        $card->setType(strtolower($typeDetector->detect($info['number'])));
        $card->setNumber($info['number']);
        $card->setExpireMonth($info['expiredMonth']);
        $card->setExpireYear('20' . $info['expiredYear']);
        $card->setFirstName($info['firstname']);
        $card->setLastName($info['lastname']);


        $fundingInstrument = new FundingInstrument();
        $fundingInstrument->setCreditCard($card);

        $payer = new Payer();
        $payer->setPaymentMethod("credit_card");
        $payer->setFundingInstruments(array($fundingInstrument));

        $amount = new Amount();
        $amount->setCurrency($info['currency']);
        $amount->setTotal($info['price']);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("creating a direct payment with credit card");

        $this->payment = new PayPalPayment();
        $this->payment->setIntent("sale");
        $this->payment->setPayer($payer);
        $this->payment->setTransactions(array($transaction));

        try {
            $this->payment->create($apiContext);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}