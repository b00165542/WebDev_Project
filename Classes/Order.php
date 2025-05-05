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
        $new_order = [
            'userID' => $userId,
            'eventID' => $eventDetails['id'],
            'totalAmount' => $total,
            'orderDate' => $orderDate,
            'quantity' => 1
        ];
        $sql = sprintf(
            "INSERT INTO orders (%s) VALUES (%s)",
            implode(", ", array_keys($new_order)),
            ":" . implode(", :", array_keys($new_order))
        );
        $stmt = $conn->prepare($sql);
        foreach ($new_order as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }
        $stmt->execute();
        return $conn->lastInsertId();
    }
}