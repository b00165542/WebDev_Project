<?php
require_once '../Classes/session.php';
include '../Layout/Header.php';
session::requireLogin();

if (isset($_SESSION['last_order'])){
    $order = $_SESSION['last_order'];
}
else{
    $order = null;
}

require_once '../Classes/Order.php';

?>

<div class="container">
    <div class="thank-you-container">
        <div class="thank-you-header">
            <div class="thank-you-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="thank-you-message">
                <h1>Thank You for Your Purchase!</h1>
                <p>Your order has been confirmed and processed successfully.</p>
            </div>
        </div>

        <?php if ($order) { ?>
        <div class="order-summary card">
            <h2>Order Summary</h2>
            <div class="order-info">
                <div class="order-info-item">
                    <span class="label">Order #:</span>
                    <span class="value"><?php echo $order['id']; ?></span>
                </div>
                <div class="order-info-item">
                    <span class="label">Event:</span>
                    <span class="value"><?php echo $order['event_name']; ?></span>
                </div>
                <div class="order-info-item">
                    <span class="label">Date:</span>
                    <span class="value"><?php echo $order['event_date']; ?></span>
                </div>
                <div class="order-info-item">
                    <span class="label">Location:</span>
                    <span class="value"><?php echo $order['event_location']; ?></span>
                </div>
                <div class="order-info-item">
                    <span class="label">Quantity:</span>
                    <span class="value"><?php echo $order['quantity']; ?></span>
                </div>
                <div class="order-info-item total">
                    <span class="label">Total:</span>
                    <span class="value">$<?php echo number_format($order['total'], 2); ?></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="next-steps card">
            <h2>What's Next?</h2>
            <p>Your ticket information has been saved to your account. You can view your purchase history in your profile.</p>
            <div class="action-buttons">
                <a href="/SET/public/profile.php" class="btn btn-primary"><i class="fa fa-user"></i> View Your Profile</a>
                <a href="/SET/public/product.php" class="btn btn-secondary"><i class="fa fa-ticket"></i> Browse More Events</a>
            </div>
        </div>
    </div>
</div>

<?php include "../Layout/Footer.php"; ?>
