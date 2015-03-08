<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Group controller
 * @copyright Copyright (c) 2014
 * @author    Surapun Prasit
 * @package   Payment
 */
class IndexController extends AbstractActionController{
    /**
     * (non-PHPdoc)
     * @see \ZeroEngine\Api\Server\Rest\ApiRestfulController::get()
     */
    public function indexAction() {
        $view = new ViewModel();

        return $view->setTemplate('payment/index');;
    }

    public function payAction() {
        $view = new ViewModel();

        $post = $this->getRequest()->getPost();
        $paymentService = $this->getServiceLocator()->get('payment');

        $result = $paymentService->pay($post);

        return $view->setVariable('success', $result)
                    ->setTemplate('payment/pay');
    }
}
