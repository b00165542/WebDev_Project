<?php include "Classes/dbConnection.php"; ?>

<?php
// Get the connection using the dbConnection class
$conn = Classes\dbConnection::getConnection();

// Query to get all tickets (with event details)
$sql = "SELECT t.ticketID, t.ticketPrice, e.eventName, e.eventLocation, e.eventDate 
        FROM Tickets t 
        JOIN Events e ON t.eventID = e.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any tickets
if (count($result) > 0) {
    // Start the product grid layout
    echo "<div class='product-grid'>";

    // Fetch each ticket and display it
    foreach ($result as $row) {
        echo "<div class='product'>
                <h3 class='product-name'>" . htmlspecialchars($row['eventName']) . "</h3>
                <p class='product-location'>" . htmlspecialchars($row['eventLocation']) . "</p>
                <p class='product-date'>" . htmlspecialchars($row['eventDate']) . "</p>
                <p class='product-price'>$" . number_format($row['ticketPrice'], 2) . "</p>
                <a href='#' class='buy-button'>Buy Now</a>
              </div>";
    }

    // Close the product grid layout
    echo "</div>";
} else {
    echo "No tickets found.";
}

$conn = null; // Close the connection
?>

<?php include "Layout/Footer.php"; ?>
