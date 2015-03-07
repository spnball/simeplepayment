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
class PayPalLibraryAccess extends AbstractHttpControllerTestCase
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
                class_exists('\PayPal\Auth\OAuthTokenCredential'),
                'There is not OAuthTokenCredential'
        );

        $this->assertTrue(
                class_exists('\PayPal\Rest\ApiContext'),
                'There is not ApiContext'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\CreditCard'),
                'There is not CreditCard'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\FundingInstrument'),
                'There is not FundingInstrument'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\Payer'),
                'There is not Payer'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\Amount'),
                'There is not Payer'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\Transaction'),
                'There is not Payer'
        );

        $this->assertTrue(
                class_exists('\PayPal\Api\Payment'),
                'There is not Payer'
        );
    }

    public function testPaypalAuthenticate ()
    {
        $paypalPayment = new Payment();
        $paypalPayment->setServiceLocator($this->getApplicationServiceLocator());
        $config = $paypalPayment->getApiConfig();

        $this->assertTrue(is_array($config));

        $this->assertTrue(
                isset($config['clientId']),
                'Paypal clientId configuration'
        );
        $this->assertTrue(
                isset($config['secret']),
                'Paypal secret configuration'
        );
    }
}
