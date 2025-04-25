<?php
// Include necessary classes
require_once '../Classes/Customer.php';
require_once '../Classes/User.php';
require_once '../Classes/dbConnection.php';
require_once '../Classes/session.php';

// Initialize variables
$name = $email = '';
$success_message = '';

// Check if user is already logged in
if (isset($_SESSION['userID'])) {
    // Redirect to the profile page
    header("Location: profile.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new Customer(null, $email, 0, $password, $name);
    if ($user->save()) {
        $success_message = "Registration successful! You can now <a href='login.php'>login</a>.";
    }
}

include "../Layout/Header.php";

?>

<div class="container centered-form-container">
    <div class="card">
        <form id="register-form" action="../public/Register.php" method="POST" novalidate>
            <h2 class="card-title">Create an Account</h2>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) { ?>
            <div class="notification success">
                Registration successful! You can now <a href='login.php'>login</a>.
            </div>
            <?php } ?>
            
            <div class="form-group">
                <label for="name">Full Name <span class="highlight">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name); ?>" required minlength="2">
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span class="highlight">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo htmlspecialchars($email); ?>" required minlength="8">
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
                <p>Already have an account? <a href="/SET/public/login.php">Login</a></p>
            </div>
        </form>
    </div>
</div>

<?php include "../Layout/Footer.php"; ?>
