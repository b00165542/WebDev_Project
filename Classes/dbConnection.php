<?php
namespace Classes;

use PDO;
use PDOException;

class dbConnection
{
    private $host = "localhost";
    private $db_name = "Tickets_db"; // Database name
    private $username = "root"; // Database username
    private $password = ""; // Database password (none in this case)
    private static $connection = null;

    // Using a static method to implement a Singleton-like pattern
    public static function getConnection()
    {
        if (self::$connection === null) {
            try {
                // Set DSN
                $dsn = "mysql:host=" . (new self)->host . ";dbname=" . (new self)->db_name;
                self::$connection = new PDO($dsn, (new self)->username, (new self)->password);

                // Optional PDO attributes
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Handle connection error
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}
