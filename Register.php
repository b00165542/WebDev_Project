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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user'; // Default role for a user

    // Insert user data into the Users table
    $sql = "INSERT INTO Users (userName, userPassword, userEmail, userRol, userAge) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $role, $phone);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<?php include "Layout/Header.php"; ?>

        <form action = "POST">
            <h2> Sign Up</h2>
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
                <input type="text" placeholder="Enter your Username" required />
            </div>
            <br>
            <div class="input-field">
                <input type="password" placeholder="Enter your Password" required />
            </div>
            <br>
            <div class="input-field">
                <input type="password" placeholder="Enter your Re-Enter Password" required />
            </div>
            <br>
            <input class="Login_button" type="submit" value="Sign Up">
            <br>
            <p> Have an account? <span><a href = "Login.php">Login</a></span></p>
        </form>

<?php include "Layout/Footer.php"; ?>
