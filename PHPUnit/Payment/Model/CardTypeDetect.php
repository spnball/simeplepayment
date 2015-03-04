<?php

namespace PaymentTest\Model;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use PHPUnitModule\Bootstrap;
use Payment\Model\CardTypeDetect;

/**
 * Test card type detect
 * Test case form
 * http://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/credit_card_numbers.htm
 * @author spnball
 *
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
{
    /**
     * @var \Payment\Model\CardTypeDetect
     */
    protected $detector;

    /**
     * Set up test suit
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            Bootstrap::getConfig()
        );

        parent::setUp();

        $this->detector = new CardTypeDetect();
    }

    /**
     * test American Express number
     */
    public function testAMEX ()
    {
        $type = 'AMEX';
        $this->assertEquals($type, $this->detector->detect('378282246310005'));
        $this->assertEquals($type, $this->detector->detect('371449635398431'));
        $this->assertEquals($type, $this->detector->detect('378734493671000'));
    }

    /**
     * Test Visa card number
     */
    public function testVISA ()
    {
        $type = 'VISA';
        $this->assertEquals($type, $this->detector->detect('4111111111111111'));
        $this->assertEquals($type, $this->detector->detect('4012888888881881'));
        $this->assertEquals($type, $this->detector->detect('4222222222222'));
    }

    /**
     * Test Master card number
     */
    public function testMASTERCARD()
    {
        $type = 'MASTERCARD';
        $this->assertEquals($type, $this->detector->detect('5555555555554444'));
        $this->assertEquals($type, $this->detector->detect('5105105105105100'));
    }

    /**
     * Test diner club
     */
    public function testDINERSCLUB ()
    {
        $type = 'DINERSCLUB';
        $this->assertEquals($type, $this->detector->detect('30569309025904'));
        $this->assertEquals($type, $this->detector->detect('38520000023237'));
    }

    /**
     * Test discover card number
     */
    public function testDISCOVER()
    {
        $type = 'DISCOVER';
        $this->assertEquals($type, $this->detector->detect('6011111111111117'));
        $this->assertEquals($type, $this->detector->detect('6011000990139424'));
    }

    /**
     * Test discover card number
     */
    public function testJCB ()
    {
        $type = 'JCB';
        $this->assertEquals($type, $this->detector->detect('3530111333300000'));
        $this->assertEquals($type, $this->detector->detect('3566002020360505'));
    }

    /**
     * Test fail
     */
    public function testFail()
    {
        $this->assertFalse($this->detector->detect('a105105105105100'));
    }
}
