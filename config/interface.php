<?php
return array(
    'controllers' => array(
        'invokables' => array(
                'payment/index'       => '\Payment\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
                'payment/index' => __DIR__ . '/../view/template/index.phtml',
                'payment/pay' => __DIR__ . '/../view/template/pay.phtml',
        )
    )
);
