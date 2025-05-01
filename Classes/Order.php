<?php
// Include dependencies
require_once '../Classes/dbConnection.php';

class Order{
    private $orderID;
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * Place an order: handles capacity, ticket creation, and order insertion
     *
     * @return int New order ID
     */
    public static function place(PDO $conn, $userId, array $eventDetails){
        $orderDate = date('Y-m-d');
        $total = $eventDetails['eventPrice'];
        $stmt = $conn->prepare("INSERT INTO orders (userID, eventID, totalAmount, orderDate, quantity) VALUES (:userID, :eventID, :totalAmount, :orderDate, 1)");
        $stmt->execute([
            ':userID' => $userId,
            ':eventID' => $eventDetails['id'],
            ':totalAmount' => $total,
            ':orderDate' => $orderDate
        ]);
        return $conn->lastInsertId();
    }
}