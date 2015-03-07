<?php
namespace Payment\Interfaces;

interface PaymentStrategy {
    /**
     * Get payment name
     * @return string
     */
    public function getPaymentName ();

    /**
     * Select the payment type condition
     * @param string $cardInfomation
     * @return bool
     */
    public function selectPayment ($cardInfomation);


    /**
     * Get transection reference id
     * @return string
     */
    public function getPaymentId ();

    /**
     * get state
     * @return string
     */
    public function getPaymentState();

    /**
     * pay
     * @param array $information
     * @return boolean
     */
    public function pay ($information);
}
