<?php global $conn; include "Layout/Header.php" ?>
<?php include "connect/DBconnect.php"?>
<?php
// Query to get upcoming events
$sql = "SELECT eventName, eventLocation, eventDate FROM Events WHERE eventDate >= CURDATE() ORDER BY eventDate LIMIT 5";
$result = $conn->query($sql);

echo "<h1>Home Page</h1>";
echo "<div class='container'>
        <h2>Upcoming Sports Events</h2>
        <p>Discover and register for casual sports events happening near you!</p>
        <div class='events-list'>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='event'>
                <h3>" . $row['eventName'] . "</h3>
                <p>" . $row['eventLocation'] . "</p>
                <p>" . $row['eventDate'] . "</p>
              </div>";
    }
} else {
    echo "No upcoming events found.";
}

echo "</div></div>";

$conn->close();
?>

<?php include "Layout/Footer.php" ?>