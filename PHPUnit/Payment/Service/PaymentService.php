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
class PaymentService extends AbstractHttpControllerTestCase
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
    public function testPayment ()
    {
        $paymentService = $this->getApplicationServiceLocator()->get('payment');

        $result = $paymentService->pay(array(
               'number' => '4446283280247004',
               'expiredMonth' => '11',
               'expiredYear' => '18',
               'firstname' => 'Joe',
               'lastname' => 'Shopper',
               'currency' => 'USD',
               'price' => '12'
        ));

        $this->assertTrue($result);
    }

    public function testBraintree ()
    {
        $paymentService = $this->getApplicationServiceLocator()->get('payment');

        $result = $paymentService->pay(array(
                'number' => '4111111111111111',
                'expiredMonth' => '05',
                'expiredYear' => '12',
                'firstname' => 'Jim',
                'lastname' => 'Saler',
                'currency' => 'THB',
                'price' => '12'
        ));

        $this->assertTrue($result);
    }
}
