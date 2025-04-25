<?php
// Include base User class
require_once '../Classes/User.php';

class Customer extends User {
    public function __construct($userID, $userEmail, $isAdmin = 0, $userPassword = null, $name = '') {
        parent::__construct($userID, $userEmail, $isAdmin, $userPassword, $name);
    }
}