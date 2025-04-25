<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';

/**
 * Basic Unit Test for the Order class
 * Tests order creation and retrieval
 */
class OrderTest {
    private $testResults = [];
    private $testEventId = null;
    private $testUserId = 1; // Assuming user ID 1 exists in the database
    
    /**
     * Run all tests
     */
    public function runTests() {
        $this->setupTestEvent();
        $this->testOrderPlace();
        $this->displayResults();
    }
    
    /**
     * Create a test event for our orders
     */
    private function setupTestEvent() {
        $uniqueName = 'Test Event for Orders ' . time();
        $location = 'Test Location';
        $date = '2025-08-20';
        $price = 15.99;
        $capacity = 100;
        
        $event = new Event($uniqueName, $location, $date, $price, $capacity);
        
        if ($event->saveEvent()) {
            $this->testEventId = $event->getEventID();
            $this->addResult('Setup test event', true);
        } else {
            $this->addResult('Setup test event', false, 'Failed to create test event');
        }
    }
    
    /**
     * Test order placement
     */
    private function testOrderPlace() {
        if (!$this->testEventId) {
            $this->addResult('Place order', false, 'No test event available');
            return;
        }
        
        // Get event details
        $event = Event::findById($this->testEventId);
        if (!$event) {
            $this->addResult('Place order', false, 'Could not find test event');
            return;
        }
        
        // Create event details array
        $eventDetails = [
            'id' => $event->getEventID(),
            'eventName' => $event->getEventName(),
            'eventDate' => $event->getEventDate(),
            'eventLocation' => $event->getEventLocation(),
            'eventPrice' => $event->getEventPrice()
        ];
        
        // Place order
        $quantity = 2;
        $orderResult = Order::place($this->testUserId, $eventDetails, $quantity);
        
        $result = ($orderResult['success'] === true &&
                  isset($orderResult['id']) &&
                  $orderResult['quantity'] === $quantity);
        
        $this->addResult('Place order', $result, $result ? 'Order ID: ' . $orderResult['id'] : 'Order placement failed');
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
        echo "<h1>Order Class Unit Tests</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Test</th><th>Result</th><th>Message</th></tr>";
        
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
$orderTest = new OrderTest();
$orderTest->runTests();
?>
