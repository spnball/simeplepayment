<?php

namespace PaymentTest\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;

/**
 * Test payment selector
 * http://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/credit_card_numbers.htm
 * @author spnball
 *
 */
class PaymentSelector extends AbstractHttpControllerTestCase
{
    /**
     * @var \Payment\Service\Payment
     */
    protected $selector;

    /**
     * get payment Service
     * @return \Payment\Service\Payment
     */
    protected function getPaymentService ()
    {
        return $this->getApplicationServiceLocator()->get('payment');
    }

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
     * test selector calling
     */
    public function testSelectorServiceAccessing ()
    {
        $paymentService = $this->getApplicationServiceLocator()->get('payment');
        $this->assertInstanceOf('\Payment\Service\Payment', $paymentService);
    }

    /**
     * Test if Amex and paypal selected
     */
    public function testSelectorAMEXResult ()
    {
        // false test
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
	        array(
                    'number' => '378282246310005', // AMEX card number
	                'currency' => 'THB'
            )
        ));
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'EUR'
                )
        ));

        // test true
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'USD'
                )
        )->getPaymentName());
    }

    /**
     * Test if paypal is selected
     */
    public function testPayByUSD ()
    {
        // Pay USD by Diners club must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'USD'
                )
        )->getPaymentName());

        // Pay USD by VISA must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'USD'
                )
        )->getPaymentName());


        // Pay USD by Master card must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'USD'
                )
        )->getPaymentName());

        // Pay USD by AMEX must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'USD'
                )
        )->getPaymentName());
    }

    public function testPayByEURO ()
    {
        // Pay EUR by Diners club must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'EUR'
                )
        )->getPaymentName());

        // Pay EUR by VISA must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'EUR'
                )
        )->getPaymentName());


        // Pay EUR by Master card must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'EUR'
                )
        )->getPaymentName());

        // Pay EUR by AMEX must be false
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'EUR'
                )
        ));
    }

    public function testPayByAUD ()
    {
        // Pay AUD by Diners club must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'AUD'
                )
        )->getPaymentName());

        // Pay AUD by VISA must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'AUD'
                )
        )->getPaymentName());


        // Pay AUD by Master card must be paypal
        $this->assertEquals('paypal', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'AUD'
                )
        )->getPaymentName());

        // Pay AUD by AMEX must be false
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'AUD'
                )
        ));
    }

    public function testPayByTHB ()
    {
        // Pay THB by Diners club must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'THB'
                )
        )->getPaymentName());

        // Pay THB by VISA must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'THB'
                )
        )->getPaymentName());


        // Pay THB by Master card must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'THB'
                )
        )->getPaymentName());

        // Pay THB by AMEX must be false
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'THB'
                )
        ));
    }

    public function testPayByHKD ()
    {
        // Pay HKD by Diners club must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'HKD'
                )
        )->getPaymentName());

        // Pay HKD by VISA must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'HKD'
                )
        )->getPaymentName());


        // Pay HKD by Master card must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'HKD'
                )
        )->getPaymentName());

        // Pay HKD by AMEX must be false
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'HKD'
                )
        ));
    }

    public function testPayBySGD ()
    {
        // Pay SGD by Diners club must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // Diners club
                        'currency' => 'SGD'
                )
        )->getPaymentName());

        // Pay SGD by VISA must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '30569309025904', // VISA
                        'currency' => 'SGD'
                )
        )->getPaymentName());


        // Pay SGD by Master card must be paypal
        $this->assertEquals('braintree', $this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '5555555555554444', // Master card
                        'currency' => 'SGD'
                )
        )->getPaymentName());

        // Pay SGD by AMEX must be false
        $this->assertFalse($this->getPaymentService()->getPaymentStrategy(
                array(
                        'number' => '378282246310005', // AMEX card number
                        'currency' => 'SGD'
                )
        ));
    }
}
