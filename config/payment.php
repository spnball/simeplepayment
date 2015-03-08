<?php
return array(
        'db' => array(
                'driver' => 'Pdo_Mysql',
//                 'database' => 'payment database',
//                 'username' => 'mysql user',
//                 'password' => 'mysql password'
        ),

        'payment' => array(
                'paypal' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\PayPal\Payment',

                        // api config (optional)
//                         'api' => array(
//                                 'sdk' => array(
//                                         'mode' => 'sandbox',
//                                 ),
//                                 'clientId' => "Paypal's client id",
//                                 'secret' => "Paypal's secret id"
//                         )
                ),
                'braintree' => array (
                        // strategy classs (required)
                        'strategy' => '\Payment\Strategy\Braintree\Payment',

//                         'api' => array(
//                 	            'merchantId' => "Braintree's merchant id",
//                                 'publicKey'  => "Braintree's public key",
//                                 'privateKey' => "Braintree's private key"
//                         )
                )
        )

);