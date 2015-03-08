<?php

namespace PaymentTest\TableGateway;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;
use Payment\TableGateway\PaymentTable as PaymentTableGateway;

/**
 * Test payment selector
 * http://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/credit_card_numbers.htm
 * @author spnball
 *
 */
class PaymentTable extends AbstractHttpControllerTestCase
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

    public function testInsertPayment ()
    {
        $paymentTable = new PaymentTableGateway();

        $paymentTable->setServiceLocator($this->getApplicationServiceLocator());
        $paymentTable
            ->setFirstname('Christiano')
            ->setLastname('Ronaldo')
            ->setPrice('20')
            ->setCurrency('EUR')
            ->setTransactionRef('PAY-kKdklso8ichs')
            ->setPaymentStrategy('paypal');

        $this->assertTrue($paymentTable->savePayment() !== false);
    }
}