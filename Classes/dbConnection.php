<?php
class dbConnection {
    public static function getConnection() {
        $host = "localhost";
        $db_name = "tickets_db";
        $username = "root";
        $password = "root";
        $dsn = "mysql:host=$host;dbname=$db_name";
        $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];
        try {
            return new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
}
