<?php

namespace PaymentTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            Bootstrap::getConfig()
        );
        parent::setUp();
    }

    public function testPaymentIndexActionCanBeAccessed()
    {
        // check payment index action existing
        $this->dispatch('/payment');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Payment');
        $this->assertControllerName('payment/index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('standardPayment');
    }

}