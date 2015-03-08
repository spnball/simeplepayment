<?php
namespace Payment\TableGateway;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;

class PaymentTable
{
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    protected $tableGateway;

    /**
     * @var \Zend\ServiceManager\ServiceLocatorAwareInterface
     */
    protected $serviceLocator;

    /**
     * \Zend\ServiceManager\ServiceLocatorAwareInterface
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setServiceLocator ($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @param string $price
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setPrice ($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param unknown $firstname
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setFirstname ($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @param string $lastname
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setLastname ($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @param string $ref
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setTransactionRef ($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * @param string $type
     * @return \Album\Model\PaymentTable
     */
    public function setPaymentStrategy ($type)
    {
        $this->paymentStrategy = $type;
        return $this;
    }

    /**
     * @param string $price
     * @return \Payment\TableGateway\PaymentTable
     */
    public function setCurrency ($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function savePayment ()
    {
        $config = $this->serviceLocator->get('config');

        if (!isset($config['db'])) {
            throw new \Exception('DB is not configured.');
        }
        $adapter = new Adapter($config['db']);
        $sql = new Sql($adapter);

        $data = array(
               'ref' => $this->ref,
               'payment' => $this->paymentStrategy,
               'firstname' => $this->firstname,
               'lastname' => $this->lastname,
               'currency' => $this->currency,
               'price' => $this->price,
               'created' => new Expression("NOW()")
        );

        $insert = $sql->insert();
        $insert->into('payment')
            ->values($data);

        $statement = $sql->prepareStatementForSqlObject($insert);
        return $statement->execute();
    }
}