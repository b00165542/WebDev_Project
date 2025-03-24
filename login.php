<?php
// Include the dbConnection class
include 'Classes/dbConnection.php'; // Ensure correct path

// Get the connection
$conn = Classes\dbConnection::getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Query to get the user by email
        $sql = "SELECT * FROM Users WHERE userEmail = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and verify the password
        if ($user && password_verify($password, $user['userPassword'])) {
            // Start session and store user data
            session_start();
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userEmail'] = $user['userEmail'];

            // Redirect to the homepage or dashboard
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php include "Layout/Header.php"; ?>

<form action="login.php" method="POST">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Enter your Email Address" required />
    <input type="password" name="password" placeholder="Enter your Password" required />
    <input class="Login_button" type="submit" value="Login">
    <p>Don't have an account? <a href="register.php">Sign up</a></p>
</form>

<?php include "Layout/Footer.php"; ?>
