<?php
// Include base User class
require_once '../Classes/User.php';

class Customer extends User {
    private $customerID;

    public function __construct($userID, $userEmail, $isAdmin = 0, $userPassword = null, $customerID = null, $name = '') {
        parent::__construct($userID, $userEmail, $isAdmin, $userPassword, $name);
        $this->customerID = $customerID;
    }
}