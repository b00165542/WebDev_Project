<?php
include "../Layout/Header.php";
require_once '../Classes/Customer.php';
require_once '../Classes/User.php';
require_once '../Classes/dbConnection.php';
require_once '../Classes/session.php';

$registerName = $registerEmail = '';
$success_message = '';
$error_message = '';

// Check if user is already logged in
if (isset($_SESSION['userID'])) {
    header("Location: profile.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registerName = $_POST['name'];
    $registerEmail = $_POST['email'];
    $password = $_POST['password'];

    // Check for duplicate email
    if (User::findByEmail($registerEmail)) {
        $error_message = "Error: A user with this email already exists.";
    } else {
        $user = new Customer(null, $registerEmail, $password, $registerName, 0);
        if ($user->save()) {
            $success_message = "Registration successful! You can now login. Redirecting...";
            echo '<script>setTimeout(function(){ window.location.href = "login.php"; }, 2500);</script>';
        }
    }
}
?>

<div class="container centered-form-container">
    <div class="card">
        <form id="register-form" action="../public/Register.php" method="POST" novalidate>
            <h2 class="card-title">Create an Account</h2>
            <?php if (!empty($success_message)) { ?>
            <div class="notification success">
                <?php echo $success_message; ?>
            </div>
            <?php } elseif (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            
            <div class="form-group">
                <label for="name">Full Name <span class="highlight">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" value="<?php echo htmlspecialchars($registerName); ?>" required minlength="2" autocomplete="off">
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span class="highlight">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo htmlspecialchars($registerEmail); ?>" required minlength="8">
                <div class="invalid-feedback"></div>
                <small class="form-text">We'll never share your email with anyone else</small>
            </div>
            
            <div class="form-group">
                <label for="password">Password <span class="highlight">*</span></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required minlength="8">
                <div class="invalid-feedback"></div>
                <small class="form-text">Password must be at least 8 characters long</small>
            </div>
            
            
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
            
            <div class="form-footer">
                <p>Already have an account? <a href="../public/login.php">Login</a></p>
            </div>
        </form>
    </div>
</div>

<?php include "../Layout/Footer.php"; ?>
