<?php
require_once '../Classes/dbConnection.php';
class Refund{
    public function processRefund($userID, $orderID){
        $conn = dbConnection::getConnection();
        if (!$orderID) {
            return ['success'=>false, 'message'=>'Invalid order ID'];
        }
        $checkOrderStmt = $conn->prepare("SELECT * FROM orders WHERE orderID = :orderID AND userID = :userID");
        $checkOrderStmt->execute([':orderID' => $orderID, ':userID' => $userID]);
        $order = $checkOrderStmt->fetch(PDO::FETCH_ASSOC);
        if (!$order) {
            return ['success'=>false, 'message'=>'Order not found'];
        }
        $refundAmount = $order['totalAmount'];
        $refundDate = date('Y-m-d');
        $checkColumnStmt = $conn->prepare("SHOW COLUMNS FROM orders LIKE 'status'");
        $checkColumnStmt->execute();
        if ($checkColumnStmt->rowCount() > 0){
            $insertRefund = $conn->prepare("INSERT INTO refunds (userID, refundAmount, orderID, refundDate) VALUES (:userID, :refundAmount, :orderID, :refundDate)");
            $insertRefund->execute([
                ':userID' => $userID,
                ':refundAmount' => $refundAmount,
                ':orderID' => $orderID,
                ':refundDate' => $refundDate
            ]);
            $updateOrder = $conn->prepare("UPDATE orders SET status = 'refunded' WHERE orderID = :orderID AND userID = :userID");
            $updateOrder->execute([':orderID' => $orderID, ':userID' => $userID]);
        }
        return ['success'=>true];
    }
    public function getUserRefunds($userID){
        $conn = dbConnection::getConnection();
        $sql = "SELECT r.*, o.totalAmount as orderAmount FROM refunds r JOIN orders o ON r.orderID = o.orderID WHERE r.userID = :userID ORDER BY r.refundDate DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}