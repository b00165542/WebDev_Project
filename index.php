<?php include "Layout/Header.php" ?>

<?php
// Include the Database class for PDO connection
require_once 'Classes/dbConnection.php';
use Classes\dbConnection;

try {
    // Get the PDO connection
    $conn = dbConnection::getConnection();

    // Query to get upcoming events
    $sql = "SELECT eventName, eventLocation, eventDate FROM Events WHERE eventDate >= CURDATE() ORDER BY eventDate LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h1>Home Page</h1>";
    echo "<div class='container'>
            <h2>Upcoming Sports Events</h2>
            <p>Discover and register for casual sports events happening near you!</p>
            <div class='events-list'>";

    if ($stmt->rowCount() > 0) {
        // Loop through the results and display each event
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='event'>
                    <h3>" . htmlspecialchars($row['eventName']) . "</h3>
                    <p>" . htmlspecialchars($row['eventLocation']) . "</p>
                    <p>" . htmlspecialchars($row['eventDate']) . "</p>
                  </div>";
        }
    } else {
        echo "No upcoming events found.";
    }

    echo "</div></div>";

} catch (PDOException $e) {
    // Catch any errors with the database connection
    echo "Error: " . $e->getMessage();
}

?>

<?php include "Layout/Footer.php" ?>
