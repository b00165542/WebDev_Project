<?php
/**
 * Validation Test for SET
 * Tests various validation rules for user inputs
 */
class ValidationTest {
    private $testResults = [];
    
    /**
     * Run all validation tests
     */
    public function runTests() {
        $this->testEmailValidation();
        $this->testPasswordValidation();
        $this->testQuantityValidation();
        $this->testEventDateValidation();
        $this->testEventPriceValidation();
        $this->displayResults();
    }
    
    /**
     * Test #1: Email validation
     * Validates that email addresses are properly formatted
     */
    private function testEmailValidation() {
        // Valid email formats
        $valid = [
            'user@example.com',
            'user.name@example.co.uk',
            'user+tag@example.org'
        ];
        
        // Invalid email formats
        $invalid = [
            'plainaddress',
            '@missinguser.com',
            'user@',
            'user@.com',
            'user@example..com'
        ];
        
        $allValid = true;
        $allInvalid = true;
        
        foreach ($valid as $email) {
            if (!$this->validateEmail($email)) {
                $allValid = false;
                break;
            }
        }
        
        foreach ($invalid as $email) {
            if ($this->validateEmail($email)) {
                $allInvalid = false;
                break;
            }
        }
        
        $this->addResult('Email validation', $allValid && $allInvalid, 'Testing valid and invalid email formats');
    }
    
    /**
     * Test #2: Password validation
     * Validates password strength (min length, complexity)
     */
    private function testPasswordValidation() {
        // Valid passwords (min 8 chars, at least one number)
        $valid = [
            'Password123',
            'StrongP@ss1',
            'C0mplexP@ssword'
        ];
        
        // Invalid passwords (too short or missing numbers)
        $invalid = [
            'pass',         // too short
            'password',     // no numbers
            'Pass@word'     // no numbers
        ];
        
        $allValid = true;
        $allInvalid = true;
        
        foreach ($valid as $password) {
            if (!$this->validatePassword($password)) {
                $allValid = false;
                break;
            }
        }
        
        foreach ($invalid as $password) {
            if ($this->validatePassword($password)) {
                $allInvalid = false;
                break;
            }
        }
        
        $this->addResult('Password validation', $allValid && $allInvalid, 'Testing password strength requirements');
    }
    
    /**
     * Test #3: Order quantity validation
     * Validates that quantity is a positive integer and within valid range
     */
    private function testQuantityValidation() {
        // Valid quantities
        $valid = [1, 2, 5, 10];
        
        // Invalid quantities
        $invalid = [
            0,              // zero
            -1,             // negative
            'abc',          // not a number
            1.5,            // decimal
            101             // exceeds max (assuming max is 100)
        ];
        
        $allValid = true;
        $allInvalid = true;
        
        foreach ($valid as $qty) {
            if (!$this->validateQuantity($qty)) {
                $allValid = false;
                break;
            }
        }
        
        foreach ($invalid as $qty) {
            if ($this->validateQuantity($qty)) {
                $allInvalid = false;
                break;
            }
        }
        
        $this->addResult('Order quantity validation', $allValid && $allInvalid, 'Testing valid order quantities');
    }
    
    /**
     * Test #4: Event date validation
     * Validates that event dates are in the future and properly formatted
     */
    private function testEventDateValidation() {
        // Current date and future dates
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $nextMonth = date('Y-m-d', strtotime('+1 month'));
        $nextYear = date('Y-m-d', strtotime('+1 year'));
        
        // Valid dates (in the future)
        $valid = [$tomorrow, $nextMonth, $nextYear];
        
        // Invalid dates (past or bad format)
        $invalid = [
            date('Y-m-d', strtotime('-1 day')),   // past date
            'not-a-date',                          // bad format
            '2025/01/01',                          // wrong format
            '01-01-2025'                           // wrong format
        ];
        
        $allValid = true;
        $allInvalid = true;
        
        foreach ($valid as $date) {
            if (!$this->validateEventDate($date)) {
                $allValid = false;
                break;
            }
        }
        
        foreach ($invalid as $date) {
            if ($this->validateEventDate($date)) {
                $allInvalid = false;
                break;
            }
        }
        
        $this->addResult('Event date validation', $allValid && $allInvalid, 'Testing event dates must be in the future');
    }
    
    /**
     * Test #5: Event price validation
     * Validates that prices are positive numbers with up to 2 decimal places
     */
    private function testEventPriceValidation() {
        // Valid prices
        $valid = [
            '10',
            '10.00',
            '10.5',
            '0.99',
            '100.99'
        ];
        
        // Invalid prices
        $invalid = [
            '-10',              // negative
            '-0.01',            // negative
            'abc',              // not a number
            '10.999',           // too many decimal places
            '10,000'            // comma not allowed
        ];
        
        $allValid = true;
        $allInvalid = true;
        
        foreach ($valid as $price) {
            if (!$this->validateEventPrice($price)) {
                $allValid = false;
                break;
            }
        }
        
        foreach ($invalid as $price) {
            if ($this->validateEventPrice($price)) {
                $allInvalid = false;
                break;
            }
        }
        
        $this->addResult('Event price validation', $allValid && $allInvalid, 'Testing valid price formats');
    }
    
    /**
     * Email validation function
     */
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Password validation function
     * (min 8 chars, contains at least one number)
     */
    private function validatePassword($password) {
        return strlen($password) >= 8 && preg_match('/[0-9]/', $password);
    }
    
    /**
     * Quantity validation function
     * (positive integer <= 100)
     */
    private function validateQuantity($quantity) {
        return is_numeric($quantity) && 
               is_int((int)$quantity) && 
               $quantity == (int)$quantity &&
               $quantity > 0 && 
               $quantity <= 100;
    }
    
    /**
     * Event date validation function
     * (must be YYYY-MM-DD format and in the future)
     */
    private function validateEventDate($date) {
        $today = date('Y-m-d');
        
        // Check format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }
        
        // Check valid date
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if (!$d || $d->format('Y-m-d') != $date) {
            return false;
        }
        
        // Check date is not in the past
        return $date >= $today;
    }
    
    /**
     * Event price validation function
     * (positive number with up to 2 decimal places)
     */
    private function validateEventPrice($price) {
        // Check it's numeric and positive
        if (!is_numeric($price) || (float)$price < 0) {
            return false;
        }
        
        // Check decimal places
        if (strpos($price, '.') !== false) {
            $parts = explode('.', $price);
            if (isset($parts[1]) && strlen($parts[1]) > 2) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Add test result
     */
    private function addResult($testName, $passed, $message = '') {
        $this->testResults[] = [
            'name' => $testName,
            'result' => $passed ? 'PASS' : 'FAIL',
            'message' => $message
        ];
    }
    
    /**
     * Display all test results
     */
    private function displayResults() {
        echo "<h1>Validation Tests</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Test</th><th>Result</th><th>Details</th></tr>";
        
        foreach ($this->testResults as $result) {
            $resultClass = $result['result'] === 'PASS' ? 'green' : 'red';
            echo "<tr>";
            echo "<td>{$result['name']}</td>";
            echo "<td style='color:{$resultClass}'>{$result['result']}</td>";
            echo "<td>{$result['message']}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
}

// Run tests
$validationTest = new ValidationTest();
$validationTest->runTests();
?>
