<?php
class Admin extends User {
    private $isAdmin;

    public function __construct($userID, $userName, $userEmail, $userPassword, $isAdmin) {
        parent::__construct($userID, $userName, $userEmail, $userPassword);
        $this->isAdmin = $isAdmin;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function createEvent($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity)
    {
        // Create an Event object
        $event = new Event($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity);

        // Save the event to the database
        $event->saveEvent();
    }


    public function displayAdmin() {
        $this->displayUser();
        echo "Admin Status: " . ($this->getIsAdmin() ? "Yes" : "No") . "<br>";
    }
}
