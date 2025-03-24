<?php
namespace Classes;

class Ticket
{
    private $ticketID;
    private $eventID;
    private $ticketPrice;

    // Constructor to initialize Ticket
    public function __construct($eventID, $ticketPrice)
    {
        $this->eventID = $eventID;
        $this->ticketPrice = $ticketPrice;
    }

    // Getter for ticketID
    public function getTicketID()
    {
        return $this->ticketID;
    }

    // Getter for eventID
    public function getEventID()
    {
        return $this->eventID;
    }

    // Getter for ticketPrice
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }

    // Method to save the ticket to the database
    public function saveTicket()
    {
        try {
            $db = Database::getConnection();
            $sql = "INSERT INTO Tickets (eventID, ticketPrice) VALUES (:eventID, :ticketPrice)";
            $stmt = $db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':eventID', $this->eventID);
            $stmt->bindParam(':ticketPrice', $this->ticketPrice);

            // Execute the statement
            $stmt->execute();
            echo "Ticket created successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}