<?php global $conn; include "Layout/Header.php" ?>
<?php include "connect/DBconnect.php"?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists with the entered credentials
    $sql = "SELECT * FROM Users WHERE userEmail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Bind email to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['userPassword'])) {
            // Successful login
            echo "Login successful!";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email address!";
    }
}

$conn->close();
?>

<?php include "Layout/Header.php" ?>

<form action="login.php" method="POST">
    <h2> Login </h2>
    <div class="input-field">
        <input type="email" name="email" placeholder="Enter your Email Address" required />
    </div>
    <br>
    <div class="input-field">
        <input type="password" name="password" placeholder="Enter your Password" required />
    </div>
    <br>
    <input class="Login_button" type="submit" value="Login">
    <br>
    <p> Don't have an account? <span><a href="register.php">Sign up</a></span></p>
</form>

<?php include "Layout/Footer.php" ?>

