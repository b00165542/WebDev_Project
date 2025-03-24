<?php
namespace Classes;

class Order
{
    private $orderID;
    private $userID;
    private $totalAmount;
    private $orderDate;

    // Constructor to initialize Order
    public function __construct($userID, $totalAmount)
    {
        $this->userID = $userID;
        $this->totalAmount = $totalAmount;
        $this->orderDate = date('Y-m-d H:i:s');
    }

    // Getter for orderID
    public function getOrderID()
    {
        return $this->orderID;
    }

    // Method to save the order to the database
    public function saveOrder()
    {
        try {
            $db = Database::getConnection();
            $sql = "INSERT INTO Orders (userID, totalAmount, orderDate) VALUES (:userID, :totalAmount, :orderDate)";
            $stmt = $db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':userID', $this->userID);
            $stmt->bindParam(':totalAmount', $this->totalAmount);
            $stmt->bindParam(':orderDate', $this->orderDate);

            // Execute the statement
            $stmt->execute();
            echo "Order placed successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}