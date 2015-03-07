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
class BraintreeLibraryAccess extends AbstractHttpControllerTestCase
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

    public function testDirectCreditClassExists ()
    {
        $this->assertTrue(
                class_exists('\Braintree_Configuration'),
                'There is not Braintree_Configuration'
        );
        $this->assertTrue(
                class_exists('\Braintree_Transaction'),
                'There is not Braintree_Transaction'
        );
    }
}
