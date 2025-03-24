<?php global $conn; include "Layout/Header.php" ?>
<?php include "connect/DBconnect.php"?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password']; // For confirming password match
    $role = 'user'; // Default role for a user

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Hash the password before storing it in the database for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the Users table
        $sql = "INSERT INTO Users (userName, userPassword, userEmail, userRol, userAge) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $hashedPassword, $email, $role, $phone);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>


<?php include "Layout/Header.php"; ?>


<form method="POST">
    <h2> Sign Up</h2>
    <div class="input-field">
        <input type="text" name="name" placeholder="Enter your Full Name" required />
    </div>
    <br>
    <div class="input-field">
        <input type="email" name="email" placeholder="Enter your Email Address" required />
    </div>
    <br>
    <div class="input-field">
        <input type="tel" name="phone" placeholder="Enter your Phone Number" required />
    </div>
    <br>
    <div class="input-field">
        <input type="text" name="username" placeholder="Enter your Username" required />
    </div>
    <br>
    <div class="input-field">
        <input type="password" name="password" placeholder="Enter your Password" required />
    </div>
    <br>
    <div class="input-field">
        <input type="password" name="confirm_password" placeholder="Re-Enter Password" required />
    </div>
    <br>
    <input class="Login_button" type="submit" value="Sign Up">
    <br>
    <p> Have an account? <span><a href="Login.php">Login</a></span></p>
</form>

<?php include "Layout/Footer.php"; ?>

