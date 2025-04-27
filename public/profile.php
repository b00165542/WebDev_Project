<?php
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Refund.php';
require_once '../Classes/User.php';
require_once '../Classes/Order.php';
require_once '../Classes/session.php';

if (!isset($_SESSION['userID'])){
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

if ($conn){
    $stmt = $conn->query("SELECT * FROM Users WHERE userID = $userID");
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->query("SELECT * FROM orders WHERE userID = $userID ORDER BY orderDate DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $refunds = (new Refund())->getUserRefunds($userID);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refund_order_id']) && isset($_POST['refund_request'])){
    $orderID = (int)$_POST['refund_order_id'];
    $refund = new Refund();
    $result = $refund->processRefund($userID, $orderID);
    if (!empty($result['message'])){
        $message = urlencode($result['message']);
    }
    else{
        $message = urlencode('Refund processed.');
    }
    if (!empty($result['success'])){
        header("Location: profile.php?section=orders&refund_success=1&message=" . $message);
    }
    else{
        header("Location: profile.php?section=orders&refund_error=1&message=" . $message);
    }
    exit();
}

?>

<h1>My Profile</h1>
<ul>
  <li><a href="profile.php?section=profile">Personal Info</a></li>
  <li><a href="profile.php?section=orders">Purchase History</a></li>
  <li><a href="profile.php?section=refunds">Refunds</a></li>
  <?php if ($isAdmin) { ?><li><a href="admin_events.php">Admin</a></li><?php } ?>
</ul>

<?php
$section = isset($_GET['section']) ? $_GET['section'] : 'profile';
if ($section == 'profile'){
    echo '<h2>Personal Info</h2>';
    echo 'User ID: ' . $user_info['userID'] . '<br>';
    echo 'Name: ' . $user_info['name'] . '<br>';
    echo 'Email: ' . $user_info['userEmail'] . '<br>';
}

elseif ($section == 'orders') {
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
                echo '<form method="POST" action="profile.php?section=orders">';
                echo '<input type="hidden" name="refund_order_id" value="' . $order['orderID'] . '">';
                echo '<input type="hidden" name="refund_request" value="1">';
                echo '<button type="submit" class="btn">Request Refund</button>';
                echo '</form>';
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else {
        echo 'No orders found.';
    }
}
elseif ($section == 'refunds'){
    echo '<h2>Refunds</h2>';
    if (!empty($refunds)){
        echo '<table><tr><th>Order #</th><th>Amount</th></tr>';
        foreach ($refunds as $refund){
            echo '<tr>';
            echo '<td>' . $refund['orderID'] . '</td>';
            echo '<td>$' . $refund['refundAmount'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else{
        echo '<p>No refunds found.</p>';
    }
}
elseif ($section == 'admin' && $isAdmin) {
    echo '<h2>Admin Section</h2>';
    echo '<p>Access your <a href="/SET/public/admin_events.php">Event Management</a> panel.</p>';
}
?>

<?php include "../Layout/Footer.php"; ?>
