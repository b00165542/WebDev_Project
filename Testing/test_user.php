<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/User.php';

class UserTest {
    public function runTests() {
        $this->displayUserGetters();
    }
    private function displayUserGetters() {
        $user = new User(1, 't@t.t', 'password', 'test', 0);
        echo 'UserID: ' . $user->getUserID() . '<br>';
        echo 'Name: ' . $user->getName() . '<br>';
        echo 'Email: ' . $user->getUserEmail() . '<br>';
        echo 'Password: ' . $user->getUserPassword() . '<br>';
        echo 'IsAdmin: ' . $user->getIsAdmin() . '<br>';
    }
}
$userTest = new UserTest();
$userTest->runTests();
?>
