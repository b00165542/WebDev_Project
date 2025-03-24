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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form input values
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Get the user ID based on the email (assuming email is unique)
    $sql = "SELECT idUsers FROM Users WHERE userEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['idUsers'];

        // Get the ticket ID (you might get this from session or URL)
        $ticketId = 1; // Assuming you're using a specific ticket for the checkout. Replace this with logic to get the ticket ID.

        // Get the ticket price from the Tickets table
        $ticketSql = "SELECT eventPrice FROM Tickets WHERE idTickets = ?";
        $ticketStmt = $conn->prepare($ticketSql);
        $ticketStmt->bind_param("i", $ticketId);
        $ticketStmt->execute();
        $ticketResult = $ticketStmt->get_result();
        $ticket = $ticketResult->fetch_assoc();
        $totalAmount = $ticket['eventPrice']; // This can be adjusted based on quantity or other factors

        // Insert the order into the Orders table
        $orderSql = "INSERT INTO Orders (Users_idUsers, Tickets_idTickets, totalAmount) VALUES (?, ?, ?)";
        $orderStmt = $conn->prepare($orderSql);
        $orderStmt->bind_param("iis", $userId, $ticketId, $totalAmount);

        if ($orderStmt->execute()) {
            echo "Order confirmed! Your total is $" . number_format($totalAmount, 2);
        } else {
            echo "Error: " . $orderStmt->error;
        }
    } else {
        echo "User not found. Please register first.";
    }
}

$conn->close();
?>

<?php include "Layout/Header.php" ?>

<form action = "POST">
    <h2> Checkout</h2>
    <div class="input-field">
        <input type="" placeholder="Enter your Full Name" required />
    </div>
    <br>
    <div class="input-field">
        <input type="email" placeholder="Enter your Email Address" required />
    </div>
    <br>
    <div class="input-field">
        <input type="tel" placeholder="Enter your Phone Number" required />
    </div>
    <br>
    <div class="input-field">
        <input type="text" placeholder="Enter your Address" required/>
    </div>
    <br>
    <input class="Login_button" type="submit" value="Confirm">
    <br>
</form>

<?php include "Layout/Footer.php" ?>
