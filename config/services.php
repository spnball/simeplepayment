<?php
return array
    (
       'service_manager' => array
            (
	           'factories' => array
                    (
                        'database.pim.read'  => '\Pim\Factories\MongoDb\MongoReadServiceFactory',
                        'database.pim.write' => '\Pim\Factories\MongoDb\MongoWriteServiceFactory',
                    )
            )
    );