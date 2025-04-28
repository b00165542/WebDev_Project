<?php
$host = 'localhost';
$user = 'root'; 
$pass = '';
$db = 'tickets_db';
$port = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("DROP DATABASE IF EXISTS `$db`");
    $pdo->exec("CREATE DATABASE `$db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci");
    $pdo->exec("USE `$db`");

    // Create tables
    $pdo->exec("CREATE TABLE `events` (
      `id` int NOT NULL AUTO_INCREMENT,
      `eventDate` varchar(255) DEFAULT NULL,
      `eventName` varchar(255) DEFAULT NULL,
      `eventLocation` varchar(255) DEFAULT NULL,
      `eventPrice` double DEFAULT NULL,
      `eventCapacity` int DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB;");

    $pdo->exec("CREATE TABLE `users` (
      `userID` int NOT NULL AUTO_INCREMENT,
      `userPassword` varchar(255) DEFAULT NULL,
      `userEmail` varchar(255) DEFAULT NULL,
      `isAdmin` tinyint(1) NOT NULL,
      `name` varchar(64) NOT NULL,
      PRIMARY KEY (`userID`)
    ) ENGINE=InnoDB;");

    $pdo->exec("CREATE TABLE `orders` (
      `orderID` int NOT NULL AUTO_INCREMENT,
      `userID` int DEFAULT NULL,
      `eventID` int NOT NULL,
      `totalAmount` double DEFAULT NULL,
      `orderDate` date DEFAULT NULL,
      `quantity` int NOT NULL DEFAULT '1',
      `status` varchar(20) DEFAULT 'active',
      PRIMARY KEY (`orderID`),
      KEY `userID` (`userID`),
      CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
    ) ENGINE=InnoDB;");

    $pdo->exec("CREATE TABLE `refunds` (
      `refundID` int NOT NULL AUTO_INCREMENT,
      `userID` int DEFAULT NULL,
      `refundAmount` double DEFAULT NULL,
      `orderID` int DEFAULT NULL,
      `refundDate` datetime DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`refundID`),
      KEY `userID` (`userID`),
      KEY `refunds_ibfk_2` (`orderID`),
      CONSTRAINT `refunds_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
      CONSTRAINT `refunds_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE SET NULL
    ) ENGINE=InnoDB;");

    $pdo->exec("INSERT INTO `events` (`id`, `eventDate`, `eventName`, `eventLocation`, `eventPrice`, `eventCapacity`) VALUES
    (1, '2025-03-25', 'Gaelic Football', 'Cork', 15, 100),
    (2, '2025-07-12', 'Concert', 'Los Angeles', 25, 45),
    (3, '2025-05-22', 'Just Dance', 'Galway', 10.5, 35),
    (4, '2025-07-25', 'Test', 'Belfast', 69, 1);");

    $pdo->exec("INSERT INTO `users` (`userID`, `userPassword`, `userEmail`, `isAdmin`, `name`) VALUES
    (2, 'password', 'a@a.a', 1, 'Admin'),
    (3, 'password', 'u@u.u', 0, 'User');");

    $pdo->exec("INSERT INTO `orders` (`orderID`, `userID`, `eventID`, `totalAmount`, `orderDate`, `quantity`, `status`) VALUES
    (56, 2, 7, 69, '2025-04-25', 1, 'active');");

    echo "<h2>Database install complete!</h2><p>All tables and demo data loaded.<br>Admin login: a@a.a / password<br>User login: u@u.u / password</p>";
} catch (Exception $e) {
    echo "<h2>Error:</h2><pre>" . $e->getMessage() . "</pre>";
}
?>
