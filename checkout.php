<?php include "Layout/Header.php" ?>

<form action = "POST">
    <h2> Checkout</h2>
    <div class="input-field">
        <input type="" placeholder="Enter your Full Name" required />
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
        <input type="text" placeholder="Enter your Address" required/>
    </div>
    <br>
    <input class="Login_button" type="submit" value="Confirm">
    <br>
</form>

<?php include "Layout/Footer.php" ?>
