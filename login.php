<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Events Ticketing - Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<header>
    <h1><?php echo "Login Page"; ?></h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="product.php">Search For Ticket</a>
        <a href="contact.php">Contact Page</a>
        <a href="login.php">Login Page</a>
    </nav>
</header>
<div class="container">
    <h2>Please Login</h2>
    <form method="GET" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
    <p><?php echo "Today is: " . date("l, F j, Y"); ?></p>
</div>
<footer>
    &copy; 2025 Sports Ticketing
</footer>
</body>
</html>
