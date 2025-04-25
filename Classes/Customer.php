<?php
// Include base User class
require_once '../Classes/User.php';

class Customer extends User {
    public function __construct($userID, $userEmail, $userPassword, $name, $isAdmin = 0) {
        parent::__construct($userID, $userEmail, $userPassword, $name, $isAdmin);
    }
}