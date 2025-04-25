<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Classes/session.php';
session::requireLogin();

require_once '../Classes/dbConnection.php';
require_once '../Classes/Order.php';
require_once '../Classes/Refund.php';

$userID = $_SESSION['userID'];

// Check if the request is a POST request and has an order ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'])) {
    $orderID = $_POST['orderID'];

    //Error Handling
    if (!$orderID) {
        header("Location: /SET/public/profile.php?refund_error=1&message=" . urlencode("Invalid order ID."));
        exit();
    }
    $conn = dbConnection::getConnection();
    
    if (!$conn) {
        header("Location: /SET/public/profile.php?refund_error=1&message=" . urlencode("Database connection failed."));
        exit();
    }
    
    // First check if the order exists and belongs to the user
    $checkOrderSql = "SELECT * FROM orders WHERE orderID = $orderID AND userID = $userID";
    $checkOrderStmt = $conn->prepare($checkOrderSql);
    $checkOrderStmt->execute();
    $order = $checkOrderStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        header("Location: /SET/public/profile.php?refund_error=1&message=" . urlencode("Order not found or does not belong to you."));
        exit();
    }
    
    // Check if the order is already refunded (if status column exists)
    if (isset($order['status']) && $order['status'] === 'refunded') {
        header("Location: /SET/public/profile.php?refund_error=1&message=" . urlencode("This order has already been refunded."));
        exit();
    }
    
    // Create a Refund instance
    $refund = new Refund($conn);
    
    // Process the refund
    $result = $refund->processRefund($userID, $orderID);
    
    if ($result['success']) {
        // Redirect to refunds tab with success message
        header("Location: /SET/public/profile.php?refund_success=1&message=" . urlencode($result['message']) . "&tab=refunds");
        exit();
    } else {
        // Redirect with error message
        header("Location: /SET/public/profile.php?refund_error=1&message=" . urlencode($result['message']));
        exit();
    }
} else {
    // If someone tries to access this page directly, redirect to profile page
    header("Location: /SET/public/profile.php");
    exit();
}
