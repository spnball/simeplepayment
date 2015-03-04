<?php

namespace Payment\Strategy\Paypal;

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
        return 'paypal';
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

}