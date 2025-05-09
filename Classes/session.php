<?php
require_once '../Classes/dbConnection.php';
class session{
    public function killSession(){
        $_SESSION = [];
        if (ini_get('session.use_cookies')){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }
    public function forgetSession(){
        $this->killSession();
        header("location:/SET/public/login.php");
        exit;
    }
    public static function isLoggedIn(){
        return isset($_SESSION['userID']);
    }
    public static function login($user){
        $_SESSION['userID'] = $user->getUserID();
        $_SESSION['userEmail'] = $user->getUserEmail();
        $_SESSION['isAdmin'] = $user->getIsAdmin();
        $_SESSION['name'] = $user->getName();
    }
    public static function requireLogin(){
        if (!session::isLoggedIn()) {
            header("Location: login.php");
            exit;
        }
    }
}
?>