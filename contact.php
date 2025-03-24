<?php
echo isset($_GET['name']) ? ( mail("your-email@example.com", "Contact Form", "Name: " . $_GET['name'] . "\nEmail: " . $_GET['email'] . "\nMessage: " . $_GET['message']) ? "Message sent!" : "Error sending message" ) : "";
?>
<?php include "Layout/Header.php" ?>

<form action = "POST">
    <h2> Contact Us</h2>
    <div class="input-field">
        <input type="text" placeholder="Enter your Full Name" required />
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
        <input type="text" placeholder="Whats your complaint" required />
    </div>
    <br>

    <input class="Login_button" type="submit" value="Submit">

</form>

<?php include "Layout/Footer.php" ?>

