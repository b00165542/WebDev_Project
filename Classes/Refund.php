<?php
require_once '../Classes/dbConnection.php';
class Refund{
    public function processRefund($userID, $orderID){
        $conn = dbConnection::getConnection();
        $order = $conn->query("SELECT * FROM orders WHERE orderID = $orderID AND userID = $userID")->fetch(PDO::FETCH_ASSOC);
        $refundAmount = $order['totalAmount'];
        $refundDate = date('Y-m-d');
        $conn->prepare("INSERT INTO refunds (userID, refundAmount, orderID, refundDate) VALUES (?, ?, ?, ?)")
             ->execute([$userID, $refundAmount, $orderID, $refundDate]);
        $conn->prepare("UPDATE orders SET status = 'refunded' WHERE orderID = ? AND userID = ?")
             ->execute([$orderID, $userID]);
        return true;
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