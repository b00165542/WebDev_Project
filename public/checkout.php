<?php
require_once '../Classes/session.php';
session::requireLogin();
if (!isset($_SESSION['userID'])) {
    $sessionHandler = new session();
    $sessionHandler->forgetSession();
    exit();
}
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';
require_once '../Classes/User.php';

// Get event ID from URL
$eventObj = null;
if (isset($_GET['event'])) {
    try {
        $eventObj = Event::findById($_GET['event']);
    } catch (Exception $e) {}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $eventObj) {
    $conn = dbConnection::getConnection();
    try {
        Order::place($conn, $_SESSION['userID'], [
            'id' => $eventObj->getEventID(),
            'eventPrice' => $eventObj->getEventPrice(),
            'eventName' => $eventObj->getEventName(),
            'eventDate' => $eventObj->getEventDate(),
            'eventLocation' => $eventObj->getEventLocation()
        ], 1);
    } catch (Exception $e) {}
    header("Location: /SET/public/thank-you.php");
    exit;
}
?>
<div class="container">
    <h1>Checkout</h1>
    <div class="checkout-container">
        <div class="checkout-form card">
            <h2>Billing Information</h2>
            <?php if ($eventObj) { ?>
            <form id="checkout-form" action="/SET/public/checkout.php?event=<?php echo $eventObj->getEventID(); ?>" method="POST">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" class="form-control" required placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" class="form-control" required placeholder="1234 5678 9000 0000">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" class="form-control" required placeholder="123">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Complete Purchase</button>
                </div>
            </form>
            <?php } else { ?>
            <p>No event selected.</p>
            <?php } ?>
        </div>
        <div class="order-summary card">
            <h2>Order Summary</h2>
            <?php if ($eventObj) { ?>
            <div class="event-details">
                <h3><?php echo $eventObj->getEventName(); ?></h3>
                <p><?php echo $eventObj->getEventLocation(); ?></p>
                <p><?php echo $eventObj->getEventDate(); ?></p>
                <p>Price: $<?php echo number_format($eventObj->getEventPrice(), 2); ?></p>
                <p>Quantity: 1</p>
                <p>Available Tickets: <?php echo $eventObj->getRemainingCapacity(); ?></p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php include "../Layout/Footer.php"; ?>
