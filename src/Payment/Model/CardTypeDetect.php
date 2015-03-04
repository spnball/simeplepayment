<?php

namespace Payment\Model;

/**
 * Simple detect the card type
 * Copy the expression form
 * http://stackoverflow.com/questions/72768/how-do-you-detect-credit-card-type-based-on-number
 * @copyright Copyright (c) 2014
 * @author    Surapun Prasit
 * @package   Payment
 */
class CardTypeDetect {
    protected $typeRegEx = array(
    	    'VISA'       => '/^4[0-9]{6,}$/',
            'MASTERCARD' => '/^5[1-5][0-9]{5,}$/',
            'AMEX'       => '/^3[47][0-9]{5,}$/',
            'DINERSCLUB' => '/^3(?:0[0-5]|[68][0-9])[0-9]{4,}$/',
            'DISCOVER'   => '/^6(?:011|5[0-9]{2})[0-9]{3,}$/',
            'JCB'        => '/^(?:2131|1800|35[0-9]{3})[0-9]{3,}$/',
    );

    public function detect ($creditCardNumber)
    {
        foreach ($this->typeRegEx as $type => $exp) {
            if (preg_match($exp, $creditCardNumber)) {
                return $type;
            }
        }

        return false;
    }
}