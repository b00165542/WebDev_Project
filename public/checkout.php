<?php
include "../Layout/Header.php";
session::requireLogin();
if (!isset($_SESSION['userID'])){
    $sessionHandler = new session();
    $sessionHandler->forgetSession();
    exit();
}
require_once '../Classes/dbConnection.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';
require_once '../Classes/User.php';

$eventObj = null;
$error_message = '';
if (isset($_GET['event'])){
    $eventObj = Event::findById($_GET['event']);
}

//User validation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $eventObj){
    $cardNumber = $_POST['cardNumber'];
    $cvv = $_POST['cvv'];
    if (strlen($cardNumber) !== 16 || !ctype_digit($cardNumber)){
        $error_message = 'Error: Card number must be 16 digits.';
    }
    elseif (strlen($cvv) !== 3 || !ctype_digit($cvv)){
        $error_message = 'Error: CVV must be 3 digits.';
    }
    else{
        $conn = dbConnection::getConnection();
        Order::place($conn, $_SESSION['userID'],
            [
              'id' => $eventObj->getEventID(),
              'eventPrice' => $eventObj->getEventPrice(),
              'eventName' => $eventObj->getEventName(),
              'eventDate' => $eventObj->getEventDate(),
              'eventLocation' => $eventObj->getEventLocation()
            ]
        );
        header("Location: /SET/public/thank-you.php");
        exit;
    }
}
?>
<div class="container">
    <h1>Checkout</h1>
    <div class="checkout-container">
        <div class="checkout-form card">
            <h2>Billing Information</h2>
            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
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
        </div>
        <div class="order-summary card">
            <h2>Order Summary</h2>
            <?php if ($eventObj){ ?>
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
