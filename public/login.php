<?php
include "../Layout/Header.php";
require_once '../Classes/User.php';
require_once '../Classes/dbConnection.php';
require_once '../Classes/session.php';

if (isset($_SESSION['userID'])){
    header("Location: index.php");
    exit();
}

$email = '';
$error_message = '';
$success_message = '';

if (!empty($_POST)){
    $user = User::findByEmail($_POST['email']);
    if ($user && $user->getUserPassword() === $_POST['password']){
        Session::login($user);
        header("Location: index.php");
        exit();
    } else{
        $error_message = "Invalid email or password.";
    }
}
?>

<div class="container centered-form-container">
    <div class="card">
        <form id="login-form" action="../public/login.php" method="POST">
            <h2 class="card-title">Login to Your Account</h2>
            <?php if (!empty($error_message)){ ?>
                <div class="alert alert-danger" id="msg"><?php echo $error_message; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="email">Email Address <span class="highlight">*</span></label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" value="<?php echo htmlspecialchars($email); ?>" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="password">Password <span class="highlight">*</span></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="form-footer">
                <p>Don't have an account? <a href="../public/register.php">Sign up</a></p>
            </div>
        </form>
    </div>
</div>

<?php include "../Layout/Footer.php"; ?>
