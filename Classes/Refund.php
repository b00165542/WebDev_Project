<?php
namespace Classes;

class Refund
{
    private $refundID;
    private $orderID;
    private $ticketID;
    private $refundAmount;
    private $refundDate;

    // Constructor to initialize Refund
    public function __construct($orderID, $ticketID, $refundAmount)
    {
        $this->orderID = $orderID;
        $this->ticketID = $ticketID;
        $this->refundAmount = $refundAmount;
        $this->refundDate = date('Y-m-d H:i:s');

    }

    // Getter for refundID
    public function getRefundID()
    {
        return $this->refundID;
    }


    // Method to save the refund to the database
    public function saveRefund()
    {
        try {
            $db = Database::getConnection();
            $sql = "INSERT INTO Refunds (orderID, ticketID, refundAmount, refundDate) VALUES (:orderID, :ticketID, :refundAmount, :refundDate)";
            $stmt = $db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':orderID', $this->orderID);
            $stmt->bindParam(':ticketID', $this->ticketID);
            $stmt->bindParam(':refundAmount', $this->refundAmount);
            $stmt->bindParam(':refundDate', $this->refundDate);

            // Execute the statement
            $stmt->execute();
            echo "Refund processed successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
}