<?php
require_once'../Classes/dbConnection.php';
require_once 'Admin.php';
require_once 'Customer.php';
class User{
    protected $userID;

    protected $userEmail;
    protected $userPassword;
    protected  $isAdmin;
    protected $name;

    public function __construct($userID, $userEmail, $userPassword, $name, $isAdmin = 0){
        $this->userID = $userID;
        $this->userEmail = $userEmail;
        $this->isAdmin = $isAdmin;
        $this->name = $name;
        $this->userPassword = $userPassword;
    }

    // Basic getters
    public function getUserID(){
        return $this->userID;
    }


    
    public function getName(){
        return $this->name;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }
    
    public function getIsAdmin(){
        return $this->isAdmin;
    }
    
    public function getUserPassword(){
        return $this->userPassword;
    }
    /**
     * Instantiate User or Admin from DB row.
     */
    public static function fromDb(array $data){
        if ($data['isAdmin'] == 1) {
            return new Admin(
                $data['userID'],
                $data['userEmail'],
                $data['userPassword'],
                $data['name'],
                $data['isAdmin']
            );
        }
        return new Customer(
            $data['userID'],
            $data['userEmail'],
            $data['userPassword'],
            $data['name'],
            $data['isAdmin']
        );
    }

    /**
     * Find a user by email.
     */
    public static function findByEmail($email){
        $db = dbConnection::getConnection();
        $stmt = $db->prepare("SELECT userID, userEmail, userPassword, isAdmin, name FROM users WHERE userEmail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data){
            return self::fromDb($data);
        }
        return null;
    }

    /**
     * Save new user to database.
     */
    public function save(){
        try{
            $db = dbConnection::getConnection();

            $new_user = [
                'userPassword' => $this->userPassword,
                'userEmail' => $this->userEmail,
                'isAdmin' => $this->isAdmin,
                'name' => $this->name
            ];
            $sql = sprintf(
                "INSERT INTO users (%s) VALUES (%s)",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
            );
            $stmt = $db->prepare($sql);
            foreach ($new_user as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $executed = $stmt->execute();
            if ($executed) {
                $this->userID = (int)$db->lastInsertId();
            }
            return $executed;
        }
        catch (\PDOException $e){
            return false;
        }
    }
}
