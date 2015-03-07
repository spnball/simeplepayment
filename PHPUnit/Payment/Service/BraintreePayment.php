<?php

namespace PaymentTest\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;
use Payment\Strategy\Braintree\Payment;

/**
 * Test payment selector
 * http://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/credit_card_numbers.htm
 * @author spnball
 *
 */
class BraintreePayment extends AbstractHttpControllerTestCase
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

    /**
     * @expectedException Exception
     */
    public function testGetPaymentIDException()
    {
        $payment = new Payment();
        $payment->setServiceLocator($this->getApplicationServiceLocator());

        $payment->getPaymentId();
    }

    /**
     * @expectedException Exception
     */
    public function testGetPaymentStateException()
    {
        $payment = new Payment();
        $payment->setServiceLocator($this->getApplicationServiceLocator());

        $payment->getPaymentState();
    }

    public function testPaySuccess ()
    {
        $info = array(
        	   'type' => 'visa',
               'number' => '4111111111111111',
               'expiredMonth' => '05',
               'expiredYear' => '12',
               'currency' => 'USD',
               'price' => '12'
        );

        $braintreePayment = new Payment();
        $braintreePayment->setServiceLocator($this->getApplicationServiceLocator());

        $this->assertTrue($braintreePayment->pay($info));
    }

    public function testPayFail()
    {
        $info = array(
                'type' => 'visa',
                'number' => '4111111111111111',
                'expiredMonth' => '05',
                'expiredYear' => '12',
                'firstname' => 'John',
                'lastname' => 'Smith',
                'currency' => 'USD',
                'price' => '12'
        );

        $braintreePayment = new Payment();
        $braintreePayment->setServiceLocator($this->getApplicationServiceLocator());

        $this->assertFalse($braintreePayment->pay($info));
    }
}
