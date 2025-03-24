<?php
// Include the dbConnection class
include 'Classes/dbConnection.php'; // Ensure correct path

// Get the connection
$conn = Classes\dbConnection::getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Basic validation
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Insert user data into the Users table
            $sql = "INSERT INTO Users (userName, userPassword, userEmail) VALUES (:userName, :userPassword, :userEmail)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userName', $username);
            $stmt->bindParam(':userPassword', $hashedPassword);
            $stmt->bindParam(':userEmail', $email);

            if ($stmt->execute()) {
                header("Location: login.php"); // Redirect to login
                exit();
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<?php include "Layout/Header.php"; ?>

<form action="register.php" method="POST">
    <h2>Sign Up</h2>
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <input type="password" name="confirmPassword" placeholder="Re-enter Password" required />
    <input class="Login_button" type="submit" value="Sign Up">
    <p>Have an account? <a href="login.php">Login</a></p>
</form>

<?php include "Layout/Footer.php"; ?>
