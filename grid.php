<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'Tickets_db';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all tickets (assuming tickets are related to events)
$sql = "SELECT t.idTickets, t.eventPrice, e.eventName, e.eventLocation, e.eventDate FROM Tickets t JOIN Events e ON t.Events_idEvents = e.idEvents";
$result = $conn->query($sql);

// Check if there are any tickets
if ($result->num_rows > 0) {
    // Start the product grid layout
    echo "<div class='product-grid'>";

    // Fetch each ticket and display it
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>
                <h3 class='product-name'>" . $row['eventName'] . "</h3>
                <p class='product-location'>" . $row['eventLocation'] . "</p>
                <p class='product-date'>" . $row['eventDate'] . "</p>
                <p class='product-price'>$" . number_format($row['eventPrice'], 2) . "</p>
                <a href='#' class='buy-button'>Buy Now</a>
              </div>";
    }

    // Close the product grid layout
    echo "</div>";
} else {
    echo "No products found.";
}

$conn->close();
?>

