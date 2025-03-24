<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'Tickets_db';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>