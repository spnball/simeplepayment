Simple Payment
=======================


Installation
------------
Install zend frameword II and see the url for instruction, 
https://github.com/zendframework/ZendSkeletonApplication
    
clone our module

    cd  /path_of_project/module
    git clone https://github.com/spnball/simeplepayment.git Payment
    
clone Braintree sdk

    cd  /path_of_project/module/Payment/src/Payment/Strategy/Braintree
    git clone  https://github.com/braintree/braintree_php.git sdk
    
clone Paypal sdk

    cd  /path_of_project/module/Payment/src/Payment/Strategy/Paypal
    git clone  https://github.com/braintree/braintree_php.git sdk
    
Configuration
-------------
Edit the api and database configuration in 

    /path_of_project/module/Payment/config/payment.php
    
PHPUnit
-------
you and run phpunit command in this directory

    /path_of_project/module/Payment
    
Implement more payment api client
---------------------------------
Create a new api class by implement "Payment\Interfaces\PaymentStrategy" interface. Then add the config in payment array with the strategy class.     
