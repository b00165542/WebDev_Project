<?php
require '../config.php';

class dbConnection
{
    public static function getConnection() {
        global $dsn, $username, $password, $options;
        try {
            return new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
}
