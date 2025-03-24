<?php
class User {
    protected $userID;
    protected $userName;
    protected $userEmail;
    protected $userPassword;

    public function __construct($userID, $userName, $userEmail, $userPassword) {
        $this->userID = $userID;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userPassword = password_hash($userPassword, PASSWORD_DEFAULT);  // Store hashed password
    }

    // Only provide safe getters for the properties
    public function getUserID() {
        return $this->userID;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }

    // Avoid returning raw password. If needed, add a password verification method
    public function verifyPassword($password) {
        return password_verify($password, $this->userPassword);
    }
}

