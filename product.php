<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Details - Sports Ticketing</title>
  <link rel="stylesheet" href="css/product.css"><link rel="stylesheet" href="css/search.css">
</head>
<body>
  <header>
      <h1><?php echo "Product Page"; ?></h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="product.php">Search For Ticket</a>
        <a href="contact.php">Contact Page</a>
        <a href="login.php">Login Page</a>
    </nav>
  </header>

  <div class="container">
      <div class="search-box">
          <input type="text" placeholder="Search for sports events...">
          <button type="button">Search</button>
      </div
  </div>
  <div class="container">
      <h2><?php echo "Featured Event"; ?></h2>
    <p>Details about the selected sports event will be displayed here. Check out the schedule, location, and ticket options.</p>
  </div>
  <footer>
    &copy; 2025 Sports Ticketing
  </footer>
</body>
</html>