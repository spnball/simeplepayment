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

    public function pay ($info)
    {
        $config = $this->getApiConfig();

        $apiContext = new ApiContext($this->authen(), 'Request' . time());
        $apiContext->setConfig($config['sdk']);

        $card = new CreditCard();
        $card->setType($info['type']);
        $card->setNumber($info['number']);
        $card->setExpireMonth($info['expiredMonth']);
        $card->setExpireYear($info['expiredYear']);
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

        $payment = new PayPalPayment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        try {
            $payment->create($apiContext);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}