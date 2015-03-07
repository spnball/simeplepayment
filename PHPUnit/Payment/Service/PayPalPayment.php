<?php

namespace PaymentTest\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;
use Payment\Strategy\Paypal\Payment;

/**
 * Test payment selector
 * http://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/credit_card_numbers.htm
 * @author spnball
 *
 */
class PayPalPayment extends AbstractHttpControllerTestCase
{
    /**
     * Set up test suit
     */
    public function setUp()
    {
        $this->setApplicationConfig(
                Bootstrap::getConfig()
        );

        parent::setUp();
    }

    public function testPaypalAuthenticate ()
    {
        $payPalPayment = new Payment();
        $payPalPayment->setServiceLocator($this->getApplicationServiceLocator());

        $token = $payPalPayment->authen()->getAccessToken(array());

        $this->assertTrue($token !== false, 'get token sucessfully');
    }

    /**
     * @expectedException Exception
     */
    public function testGetPaymentIDException()
    {
        $payment = new Payment();
        $payment->setServiceLocator($this->getApplicationServiceLocator());

        $payment->getPaymentId();
    }

    public function testPaySuccess ()
    {
        $info = array(
        	   'type' => 'visa',
               'number' => '4446283280247004',
               'expiredMonth' => '11',
               'expiredYear' => '18',
               'firstname' => 'Joe',
               'lastname' => 'Shopper',
               'currency' => 'USD',
               'price' => '12'
        );

        $payPalPayment = new Payment();
        $payPalPayment->setServiceLocator($this->getApplicationServiceLocator());

        $this->assertTrue($payPalPayment->pay($info));
    }

    public function testPayFail()
    {
        $info = array(
        	   'type' => 'visa',
               'number' => false,
               'expiredMonth' => '11',
               'expiredYear' => '2018',
               'firstname' => 'Joe',
               'lastname' => 'Shopper',
               'currency' => 'USD',
               'price' => '12'
       );

       $payPalPayment = new Payment();
       $payPalPayment->setServiceLocator($this->getApplicationServiceLocator());

       $this->assertFalse($payPalPayment->pay($info));
    }
}
