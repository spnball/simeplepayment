<?php
return array(
        'payment' => array(
                'paypal' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\Paypal\Payment',

                        // api config (optional)
                        'api' => array(
                                'mode' => 'sandbox',
                        )
                ),
                'braintree' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\Braintree\Payment',
                )
        )

);