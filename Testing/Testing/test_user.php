<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/User.php';

/**
 * Basic Unit Test for the User class
 * Tests user authentication and core user functionality
 */
class UserTest {
    private $testResults = [];
    
    /**
     * Run all tests
     */
    public function runTests() {
        $this->testUserCreation();
        $this->testUserFindByEmail();
        $this->testUserSave();
        $this->displayResults();
    }
    
    /**
     * Test user creation
     */
    private function testUserCreation() {
        // Test case: Create a new user and verify properties
        $userID = null;
        $email = 'test@example.com';
        $password = 'password123';
        $name = 'Test User';
        $isAdmin = 0;
        
        $user = new User($userID, $email, $password, $name, $isAdmin);
        
        $result = ($user->getUserEmail() === $email && 
                  $user->getUserPassword() === $password &&
                  $user->getName() === $name &&
                  $user->getIsAdmin() === $isAdmin);
        
        $this->addResult('User creation and getters', $result);
    }
    
    /**
     * Test finding user by email
     */
    private function testUserFindByEmail() {
        // This is a mock test assuming the user already exists in database
        // In a real test, you would create the user first
        $testEmail = 'admin@test.com'; // Change to an email that exists in your database
        
        $user = User::findByEmail($testEmail);
        
        $result = ($user !== null && $user->getUserEmail() === $testEmail);
        
        $this->addResult('Find user by email', $result);
    }
    
    /**
     * Test saving user to database
     */
    private function testUserSave() {
        // Create a unique test user
        $userID = null;
        $email = 'unittest_' . time() . '@example.com';
        $password = 'testpass123';
        $name = 'Unit Test User';
        $isAdmin = 0;
        
        $user = new User($userID, $email, $password, $name, $isAdmin);
        
        // Save to database
        $saveResult = $user->save();
        
        // Try to find the user we just created
        $foundUser = User::findByEmail($email);
        
        $result = ($saveResult && $foundUser !== null && $foundUser->getUserEmail() === $email);
        
        $this->addResult('Save user to database', $result);
    }
    
    /**
     * Add test result
     */
    private function addResult($testName, $passed) {
        $this->testResults[] = [
            'name' => $testName,
            'result' => $passed ? 'PASS' : 'FAIL'
        ];
    }
    
    /**
     * Display all test results
     */
    private function displayResults() {
        echo "<h1>User Class Unit Tests</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Test</th><th>Result</th></tr>";
        
        foreach ($this->testResults as $result) {
            $resultClass = $result['result'] === 'PASS' ? 'green' : 'red';
            echo "<tr>";
            echo "<td>{$result['name']}</td>";
            echo "<td style='color:{$resultClass}'>{$result['result']}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
}

// Run tests
$userTest = new UserTest();
$userTest->runTests();
?>
