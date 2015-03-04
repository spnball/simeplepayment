<?php
return array(
    'router' => array(
        'routes' => array(
        	'standardPayment' => array(
        		'type'    => 'Segment',
        		'options' => array(
        			'route'    => '/payment[/:action]',
        			'defaults' => array(
        			        'controller' => 'payment/index',
        			        'action' => 'index'
        			),
        		),
        	),
        ),
    ),
);