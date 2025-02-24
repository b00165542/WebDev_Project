<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ropa+Sans:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/checkout.css"/>
    <title>Checkout</title>
</head>
<body>
<header>
    <h1><?php echo "Checkout Page"; ?></h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="product.php">Search For Ticket</a>
        <a href="contact.php">Contact Page</a>
        <a href="login.php">Login Page</a>
    </nav>
</header>
<main>
    <form method = "GET" action="" id="form">
        <div class="menutxt">
            <fieldset>
                <legend>Shipping Information</legend>
                <label for="myname">Name:</label><br>
                <input type="text" id="myname" name="myname" maxlength="20" placeholder="Name" autocomplete="given-name" size="15"><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="johnbob@gmail.com" size="15"><br><br>

                <label for="phone">Contact Number:</label><br>
                <input type="tel" id="phone" name="phone" maxlength="10" placeholder="089 000 0000"><br><br>

                <label for="address">Address:</label><br>
                <textarea id="address" name="address" minlength="15"></textarea><br><br>
                <hr>
                <span>Save Shipping Details:</span>
                <input type="checkbox" id="saveInfo" name="saveInfo" value="Save Shipping Details"><br>

                <div class="buttons">
                    <input type="submit" value="Confirm" id="confirm">
                    <input type="reset" value="Reset">
                </div>
            </fieldset>
        </div>
    </form>
</main>
<footer>
    &copy; 2025 Sports Ticketing
</footer>
</body>
</html>
