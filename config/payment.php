<?php
return array(
        'payment' => array(
                'paypal' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\Paypal\Payment',

                        // api config (optional)
                        'api' => array(
                                'mode' => 'sandbox',
                                //'clientId' => 'type an api client id here',
                                //'secret' => 'type a secret key here'
                        )
                ),
                'braintree' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\Braintree\Payment',
                )
        )

);