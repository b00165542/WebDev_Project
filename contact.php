<?php
// When the form is submitted (GET method), send the email and show feedback.
echo isset($_GET['name']) ? ( mail("your-email@example.com", "Contact Form", "Name: " . $_GET['name'] . "\nEmail: " . $_GET['email'] . "\nMessage: " . $_GET['message']) ? "Message sent!" : "Error sending message" ) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/contact.css">
    <title>Contact Us</title>
</head>
<body>
<header>
    <h1><?php echo "Contact Page"; ?></h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="product.php">Search For Ticket</a>
        <a href="contact.php">Contact Page</a>
        <a href="login.php">Login Page</a>
    </nav>
</header>
<h2>Contact Us</h2>
<form method="GET" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea>

    <input type="submit" value="Send Message">
</form>
<footer>
    &copy; 2025 Sports Ticketing
</footer>
</body>
</html>
