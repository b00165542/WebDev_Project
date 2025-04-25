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
     * @return array Order result with keys (id, event_name, event_date, event_location, quantity, total, order_date, success, [message])
     */
    public static function place(PDO $conn, $userId, array $eventDetails, int $quantity){
        try{
            $orderDate = date('Y-m-d');
            $total = $eventDetails['eventPrice'] * $quantity;
            // Insert order directly using eventID (no tickets table)
            $conn->query("INSERT INTO orders (userID, eventID, totalAmount, orderDate, quantity) VALUES (" . $userId . ", " . $eventDetails['id'] . ", " . $total . ", '" . $orderDate . "', " . $quantity . ")");
            return [
                'success'        => true,
                'id'             => $conn->lastInsertId(),
                'event_name'     => $eventDetails['eventName'],
                'event_date'     => $eventDetails['eventDate'],
                'event_location' => $eventDetails['eventLocation'],
                'quantity'       => $quantity,
                'total'          => $total,
                'order_date'     => $orderDate
            ];
        }
        catch (PDOException $e){
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}