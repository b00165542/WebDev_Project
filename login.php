<?php include "Layout/Header.php" ?>

    <form action = "POST">
        <h2> Sign Up</h2>
        <div class="input-field">
            <input type="email" placeholder="Enter your Email Address" required />
        </div>
        <br>
        <div class="input-field">
            <input type="password" placeholder="Enter your Password" required />
        </div>
        <br>
        <input class="Login_button" type="submit" value="Login">
        <br>
        <p> Don't have an account? <span><a href = "Register.php">sign up</a></span></p>

    </form>

<?php include "Layout/Footer.php" ?>
