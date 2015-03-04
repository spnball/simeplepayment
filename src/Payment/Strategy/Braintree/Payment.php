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
     * (non-PHPdoc)
     * @see \Payment\Interfaces\PaymentStrategy::getPaymentName()
     */
    public function getPaymentName () {
        return 'braintree';
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