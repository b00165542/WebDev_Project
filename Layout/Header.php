<?php
require_once '../Classes/session.php';
session_start();

// Use session class for login logic
$isLoggedIn = session::isLoggedIn();
$name = $isLoggedIn && isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Event Ticketing</title>
    <link rel="stylesheet" href="../public/css/simple.css">
</head>
<body>
<header>
    <nav>
        <div>
            <a href="/SET/public/index.php"><strong>GameDay</strong></a>
            <a href="/SET/public/product.php">Events</a>
        </div>
        <div>
            <?php if ($isLoggedIn){ ?>
            <a href="/SET/public/profile.php">Hi, <?php echo $name; ?></a>
            <a href="/SET/public/logout.php">Logout</a>
            <?php } else{ ?>
            <a href="/SET/public/login.php">Login</a>
            <a href="/SET/public/register.php">Register</a>
            <?php } ?>
        </div>
    </nav>
</header>
<div id="notification-container"></div>
<main id="main-content">