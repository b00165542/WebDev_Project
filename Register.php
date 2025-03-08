<?php include "Layout/Header.php"; ?>

        <form action = "POST">
            <h2> Sign Up</h2>
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
                <input type="text" placeholder="Enter your Username" required />
            </div>
            <br>
            <div class="input-field">
                <input type="password" placeholder="Enter your Password" required />
            </div>
            <br>
            <div class="input-field">
                <input type="password" placeholder="Enter your Re-Enter Password" required />
            </div>
            <br>
            <input class="Login_button" type="submit" value="Sign Up">
            <br>
            <p> Have an account? <span><a href = "Login.php">Login</a></span></p>
        </form>

<?php include "Layout/Footer.php"; ?>
