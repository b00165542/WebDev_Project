<?php
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Refund.php';
require_once '../Classes/User.php';
require_once '../Classes/Order.php';
require_once '../Classes/session.php';

if (!isset($_SESSION['userID'])) {
    $sessionHandler = new session();
    $sessionHandler->forgetSession();
    exit();
}

$userID = $_SESSION['userID'];
$isAdmin = !empty($_SESSION['isAdmin']);
$conn = dbConnection::getConnection();
$user_info = array();
$orders = array();
$refunds = array();

if ($conn) {
    $stmt = $conn->query("SELECT * FROM Users WHERE userID = $userID");
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->query("SELECT * FROM orders WHERE userID = $userID ORDER BY orderDate DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $refunds = (new Refund($conn))->getUserRefunds($userID);
}

$user = new User($conn, $userID);
?>

<h1>My Profile</h1>
<ul>
  <li><a href="profile.php?section=profile">Personal Info</a></li>
  <li><a href="profile.php?section=orders">Purchase History</a></li>
  <li><a href="profile.php?section=refunds">Refunds</a></li>
  <?php if ($isAdmin) { ?><li><a href="profile.php?section=admin">Admin</a></li><?php } ?>
</ul>

<?php
$section = isset($_GET['section']) ? $_GET['section'] : 'profile';
if ($section == 'profile') {
    echo '<h2>Personal Info</h2>';
    echo 'User ID: ' . $user_info['userID'] . '<br>';
    echo 'Name: ' . $user_info['name'] . '<br>';
    echo 'Email: ' . $user_info['userEmail'] . '<br>';
} elseif ($section == 'orders') {
    echo '<h2>Purchase History</h2>';
    if (!empty($orders)) {
        echo '<table><tr><th>Date</th><th>Total</th><th>Status</th><th>Refund</th></tr>';
        foreach ($orders as $order) {
            echo '<tr>';
            echo '<td>' . $order['orderDate'] . '</td>';
            echo '<td>$' . $order['totalAmount'] . '</td>';
            echo '<td>' . ($order['status'] == 'refunded' ? 'Refunded' : 'Active') . '</td>';
            echo '<td>';
            if ($order['status'] != 'refunded') {
                echo '<form method="POST" action="/SET/public/process_refund.php">';
                echo '<input type="hidden" name="orderID" value="' . $order['orderID'] . '">';
                echo '<button type="submit" class="btn">Request Refund</button>';
                echo '</form>';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No orders found.';
    }
} elseif ($section == 'refunds') {
    echo '<h2>Refunds</h2>';
    if (!empty($refunds)) {
        echo '<table><tr><th>Order #</th><th>Amount</th></tr>';
        foreach ($refunds as $refund) {
            echo '<tr>';
            echo '<td>' . $refund['orderID'] . '</td>';
            echo '<td>$' . $refund['refundAmount'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No refunds found.</p>';
    }
} elseif ($section == 'admin' && $isAdmin) {
    echo '<h2>Admin Section</h2>';
    echo '<p>Access your <a href="/SET/public/admin_events.php">Event Management</a> panel.</p>';
}
?>

<?php include "../Layout/Footer.php"; ?>
