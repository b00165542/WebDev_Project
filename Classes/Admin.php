<?php
// Include base classes
require_once '../Classes/User.php';
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

class Admin extends User
{
    /**
     * Create a new event
     * 
     * @param string $eventName Name of the event
     * @param string $eventLocation Location of the event
     * @param string $eventDate Date of the event
     * @param float $eventPrice Price of the event
     * @param int $eventCapacity Capacity of the event
     * @param string $eventStartTime Start time of the event
     * @param string $eventFinishTime End time of the event
     * @return Event|false The created event object or false on failure
     */
    public function createEvent($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity){
        $event = new Event($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity);

        // Save the event to the database
        if ($event->saveEvent()){
            return $event;
        }
        
        return false;
    }

    public function updateEvent($eventId, $eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity){
        $event = new Event($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity);
        $event->setEventID($eventId);
        
        // Save the updated event to the database
        return $event->saveEvent();
    }
    
    /**
     * Delete an event
     * 
     * @param int $eventId ID of the event to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function deleteEvent($eventId){
        try {
            $db = dbConnection::getConnection();
            
            // No need to delete tickets, as tickets table is removed
            $sql = "DELETE FROM events WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $eventId, \PDO::PARAM_INT);
            $stmt->execute();
            
            // Check if any rows were deleted
            if ($stmt->rowCount() > 0) {
                return true;
            }
            else{
                return false; // No event found with that ID
            }
        }
        catch(\PDOException $e) {
            ErrorHandler::logError("Error deleting event", "Event ID: {$eventId}", $e);
            return false;
        }
    }
    
    /**
     * Get a single event by ID
     *
     * @param int $eventId
     * @return Event|null
     */
    public function getEventById(int $eventId){
        try{
            return Event::findById($eventId);
        }
        catch(\Exception $e){
            ErrorHandler::logError("Error fetching event by ID", "Event ID: {$eventId}", $e);
            return null;
        }
    }
}