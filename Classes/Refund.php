<?php
require_once '../Classes/dbConnection.php';
class Refund{
    
    /**
     * Process a refund by marking the order as refunded and adding a refund entry
     * 
     * @param int $userID User ID requesting the refund
     * @param int $orderID Order ID to refund
     * @return array Result with success status and message
     */
    public function processRefund($userID, $orderID){
        // Validate order belongs to user
        $checkOrderStmt = $this->conn->query("SELECT * FROM orders WHERE orderID = $orderID AND userID = $userID");
        $order = $checkOrderStmt->fetch(PDO::FETCH_ASSOC);
            
        // Get order amount for refund
        $refundAmount = $order['totalAmount'];
        $refundDate = date('Y-m-d');
            
        // Check if status column exists
        $checkColumnStmt = $this->conn->query("SHOW COLUMNS FROM orders LIKE 'status'");
            
        if ($checkColumnStmt->rowCount() == 0){
            
        // Save refund record
        $this->conn->query("INSERT INTO refunds (userID, refundAmount, orderID, refundDate) VALUES ($userID, $refundAmount, $orderID, '$refundDate')");
            
        // Update order status
        $this->conn->query("UPDATE orders SET status = 'refunded' WHERE orderID = $orderID AND userID = $userID");
        }
        return array();
    }
    
    /**
     * Get all refunds for a user
     * 
     * @param int $userID User ID to get refunds for
     * @return array List of refunds
     */
    public function getUserRefunds($userID){
        try{
            $conn = dbConnection::getConnection();
            $sql = "SELECT r.*, o.totalAmount as orderAmount FROM refunds r JOIN orders o ON r.orderID = o.orderID WHERE r.userID = :userID ORDER BY r.refundDate DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            return array();
        }
    }
}