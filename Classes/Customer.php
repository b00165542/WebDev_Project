<?php
class Customer extends User {
    private $customerID;

    public function __construct($userID, $userName, $userEmail, $userPassword, $customerID) {
        parent::__construct($userID, $userName, $userEmail, $userPassword);
        $this->customerID = $customerID;
    }

    public function getCustomerID() {
        return $this->customerID;
    }

    // __toString() method to simplify displaying user information
    public function __toString() {
        return parent::__toString() . "Customer ID: " . $this->getCustomerID() . "<br>";
    }
}
