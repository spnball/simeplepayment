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
     */
    public function selectPayment ($cardInfomation);

}
