<?php
require_once '../Classes/session.php';
include '../Layout/Header.php';
session::requireLogin();

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
