<?php
// Include base classes
require_once '../Classes/User.php';
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

class Admin extends User
{
    public function __construct($userID, $userEmail, $userPassword, $name, $isAdmin = 1) {
        parent::__construct($userID, $userEmail, $userPassword, $name, $isAdmin);
    }

     //Create a new event
    public function createEvent($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity){
        $event = new Event($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity);

        // Save the event to the database
        if ($event->saveEvent()){
            return $event;
        }
        
        return false;
    }

    //Delete Event
    public function updateEvent($eventId, $eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity){
        $event = new Event($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity);
        $event->setEventID($eventId);
        
        // Save the updated event to the database
        return $event->saveEvent();
    }
    //Delete Event
    public function deleteEvent($eventId){
            $db = dbConnection::getConnection();
            $sql = "DELETE FROM events WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            
            // Check if any rows were deleted
            if ($stmt->rowCount() > 0) {
                return true;
            }
            else{
                return false;
            }
    }
}