<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Refund.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';

/**
 * Basic Unit Test for the Refund class
 * Tests refund processing and retrieval
 */
class RefundTest {
    private $testResults = [];
    private $testEventId = null;
    private $testOrderId = null;
    private $testUserId = 1; // Assuming user ID 1 exists in the database
    
    /**
     * Run all tests
     */
    public function runTests() {
        $this->setupTestOrder();
        $this->testProcessRefund();
        $this->testGetUserRefunds();
        $this->displayResults();
    }
    
    /**
     * Create a test event and order for our refund tests
     */
    private function setupTestOrder() {
        // Create event
        $uniqueName = 'Test Event for Refunds ' . time();
        $location = 'Test Location';
        $date = '2025-09-20';
        $price = 25.99;
        $capacity = 50;
        
        $event = new Event($uniqueName, $location, $date, $price, $capacity);
        
        if (!$event->saveEvent()) {
            $this->addResult('Setup test order', false, 'Failed to create test event');
            return;
        }
        
        $this->testEventId = $event->getEventID();
        
        // Create order
        $eventDetails = [
            'id' => $event->getEventID(),
            'eventName' => $event->getEventName(),
            'eventDate' => $event->getEventDate(),
            'eventLocation' => $event->getEventLocation(),
            'eventPrice' => $event->getEventPrice()
        ];
        
        $quantity = 1;
        $orderResult = Order::place($this->testUserId, $eventDetails, $quantity);
        
        if (!$orderResult['success']) {
            $this->addResult('Setup test order', false, 'Failed to create test order');
            return;
        }
        
        $this->testOrderId = $orderResult['id'];
        $this->addResult('Setup test order', true, 'Order ID: ' . $this->testOrderId);
    }
    
    /**
     * Test refund processing
     */
    private function testProcessRefund() {
        if (!$this->testOrderId) {
            $this->addResult('Process refund', false, 'No test order available');
            return;
        }
        
        $refund = new Refund();
        $result = $refund->processRefund($this->testUserId, $this->testOrderId);
        
        $success = isset($result['success']) && $result['success'] === true;
        $this->addResult('Process refund', $success, $success ? 'Refund processed successfully' : 'Refund processing failed');
    }
    
    /**
     * Test getting user refunds
     */
    private function testGetUserRefunds() {
        $refund = new Refund();
        $refunds = $refund->getUserRefunds($this->testUserId);
        
        $result = is_array($refunds);
        $this->addResult('Get user refunds', $result, 'Found ' . count($refunds) . ' refunds');
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
        echo "<h1>Refund Class Unit Tests</h1>";
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
$refundTest = new RefundTest();
$refundTest->runTests();
?>
