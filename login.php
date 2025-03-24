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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists with the entered credentials
    $sql = "SELECT * FROM Users WHERE userEmail = ? AND userPassword = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
}

$conn->close();
?>

<?php include "Layout/Header.php" ?>

    <form action = "POST">
        <h2> Login </h2>
        <div class="input-field">
            <input type="email" placeholder="Enter your Email Address" required />
        </div>
        <br>
        <div class="input-field">
            <input type="password" placeholder="Enter your Password" required />
        </div>
        <br>
        <input class="Login_button" type="submit" value="Login">
        <br>
        <p> Don't have an account? <span><a href = "register.php">sign up</a></span></p>

    </form>

<?php include "Layout/Footer.php" ?>
