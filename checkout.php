<?php global $conn; include "Layout/Header.php" ?>
<?php include "connect/DBconnect.php"?>
<?php

// Query to get event details along with ticket prices
$sql = "SELECT e.eventName, e.eventLocation, e.eventDate, e.eventStartTime, e.eventFinishTime, e.eventPrice, t.eventPrice AS ticketPrice
        FROM Events e
        JOIN Tickets t ON e.idEvents = t.Events_idEvents";

// Execute the query
$result = $conn->query($sql);

// Check if the query returned any results
if ($result->num_rows > 0) {
    // Fetch and display each event
    $row = $result->fetch_assoc();
    $eventName = $row['eventName'];
    $eventLocation = $row['eventLocation'];
    $eventDate = $row['eventDate'];
    $eventPrice = $row['eventPrice'];
    $ticketPrice = $row['ticketPrice'];
} else {
    // If no events found, handle the error
    echo "No events found.";
    $eventName = $eventLocation = $eventDate = $eventPrice = $ticketPrice = null;
}

// Close the database connection
$conn->close();
?>

<?php include "Layout/Header.php" ?>

<div class="order-page">
    <h2>Checkout - Order Summary</h2>
    <?php if ($eventName !== null): ?>
        <div class="order-summary">
            <h3>Event Details</h3>
            <p><strong>Event:</strong> <?php echo htmlspecialchars($eventName); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($eventLocation); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($eventDate); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($eventPrice, 2); ?></p>
            <p><strong>Ticket Price:</strong> $<?php echo number_format($ticketPrice, 2); ?></p>
        </div>
    <?php else: ?>
        <p>No event data available.</p>
    <?php endif; ?>

        <h3>Billing Information</h3>
        <div class="input-field">
            <label for="fullName">Full Name:</label>
            <input type="text" name="fullName" id="fullName" placeholder="Enter your Full Name" required />
        </div>

        <div class="input-field">
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" placeholder="Enter your Email Address" required />
        </div>

        <div class="input-field">
            <label for="phone">Phone Number:</label>
            <input type="tel" name="phone" id="phone" placeholder="Enter your Phone Number" required />
        </div>

        <div class="input-field">
            <label for="address">Shipping Address:</label>
            <input type="text" name="address" id="address" placeholder="Enter your Address" required />
        </div>

        <input class="Login_button" type="submit" value="Confirm Order">
</div>

<?php include "Layout/Footer.php" ?>



