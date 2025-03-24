<?php
namespace Classes;

use PDO;
use PDOException;

class Event
{
    private $eventID;
    private $eventName;
    private $eventLocation;
    private $eventDate;
    private $eventCapacity;
    private $eventPrice;

    // Constructor to initialize Event
    public function __construct($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity = null)
    {
        $this->eventName = $eventName;
        $this->eventLocation = $eventLocation;
        $this->eventDate = $eventDate;
        $this->eventPrice = $eventPrice;
        $this->eventCapacity = $eventCapacity;
    }

    // Getter for event ID
    public function getEventID()
    {
        return $this->eventID;
    }

    // Method to save event to the database
    public function saveEvent()
    {
        try {
            // Get the PDO connection
            $db = Database::getConnection();

            // Prepare the SQL statement
            $sql = "INSERT INTO Events (eventName, eventLocation, eventDate, eventStartTime, eventFinishTime, eventPrice, eventCapacity)
                    VALUES (:eventName, :eventLocation, :eventDate, :eventStartTime, :eventFinishTime, :eventPrice, :eventCapacity)";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':eventName', $this->eventName);
            $stmt->bindParam(':eventLocation', $this->eventLocation);
            $stmt->bindParam(':eventDate', $this->eventDate);
            // If start and finish times are not provided, you can set them to a default value
            $stmt->bindParam(':eventStartTime', $startTime = '00:00:00');
            $stmt->bindParam(':eventFinishTime', $finishTime = '23:59:59');
            $stmt->bindParam(':eventPrice', $this->eventPrice);
            $stmt->bindParam(':eventCapacity', $this->eventCapacity);

            // Execute the statement
            $stmt->execute();

            // Check if the event was successfully inserted
            if ($stmt->rowCount() > 0) {
                echo "Event created successfully!";
            } else {
                echo "Failed to create the event.";
            }

        } catch (PDOException $e) {
            // Handle any errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Other getters and setters for event properties

    public function displayEvent()
    {
        echo "Event Name: " . $this->eventName . "<br>";
        echo "Location: " . $this->eventLocation . "<br>";
        echo "Date: " . $this->eventDate . "<br>";
        echo "Price: $" . $this->eventPrice . "<br>";
    }
}