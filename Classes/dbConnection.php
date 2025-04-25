<?php
class dbConnection
{
    private $host = "localhost";
    private $db_name = "tickets_db";
    private $username = "root";
    private $password = "";
    private static $connection = null;

    /**
     * Get a database connection instance
     * 
     * @return PDO|null Database connection or null if connection failed
     */
    public static function getConnection(){
        if (self::$connection === null){
            try{
                $dsn = "mysql:host=" . (new self)->host . ";dbname=" . (new self)->db_name;
                $options =
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$connection = new PDO($dsn, (new self)->username, (new self)->password, $options);
            }
            catch (\PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                return null;
            }
        }
        return self::$connection;
    }
}
