<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

/**
 * Basic Unit Test for the Event class
 * Tests event creation, retrieval, and capacity management
 */
class EventTest {
    private $testResults = [];
    private $testEventId = null;
    
    /**
     * Run all tests
     */
    public function runTests() {
        $this->testEventCreation();
        $this->testEventSave();
        $this->testFindById();
        $this->testGetAll();
        $this->testRemainingCapacity();
        $this->displayResults();
    }
    
    /**
     * Test event creation
     */
    private function testEventCreation() {
        // Create event and verify properties
        $name = 'Test Concert';
        $location = 'Test Venue';
        $date = '2025-06-15';
        $price = 29.99;
        $capacity = 100;
        
        $event = new Event($name, $location, $date, $price, $capacity);
        
        $result = ($event->getEventName() === $name && 
                  $event->getEventLocation() === $location &&
                  $event->getEventDate() === $date &&
                  $event->getEventPrice() == $price &&
                  $event->getEventCapacity() == $capacity);
        
        $this->addResult('Event creation and getters', $result);
    }
    
    /**
     * Test event save
     */
    private function testEventSave() {
        // Create a unique test event
        $uniqueName = 'Test Event ' . time();
        $location = 'Test Location';
        $date = '2025-07-20';
        $price = 19.99;
        $capacity = 50;
        
        $event = new Event($uniqueName, $location, $date, $price, $capacity);
        
        // Save to database
        $saveResult = $event->saveEvent();
        
        // Store ID for later tests
        if ($saveResult) {
            $this->testEventId = $event->getEventID();
        }
        
        $this->addResult('Save event to database', $saveResult);
    }
    
    /**
     * Test find event by ID
     */
    private function testFindById() {
        if (!$this->testEventId) {
            $this->addResult('Find event by ID', false, 'No test event ID available');
            return;
        }
        
        $foundEvent = Event::findById($this->testEventId);
        
        $result = ($foundEvent !== null && $foundEvent->getEventID() == $this->testEventId);
        
        $this->addResult('Find event by ID', $result);
    }
    
    /**
     * Test get all events
     */
    private function testGetAll() {
        $events = Event::getAll();
        
        $result = is_array($events) && count($events) > 0;
        
        $this->addResult('Get all events', $result);
    }
    
    /**
     * Test remaining capacity
     */
    private function testRemainingCapacity() {
        if (!$this->testEventId) {
            $this->addResult('Get remaining capacity', false, 'No test event ID available');
            return;
        }
        
        $event = Event::findById($this->testEventId);
        
        if (!$event) {
            $this->addResult('Get remaining capacity', false, 'Could not find test event');
            return;
        }
        
        $capacity = $event->getRemainingCapacity();
        
        // Just check that it returns a valid number
        $result = ($capacity !== null && is_numeric($capacity) && $capacity >= 0);
        
        $this->addResult('Get remaining capacity', $result);
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
        echo "<h1>Event Class Unit Tests</h1>";
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
$eventTest = new EventTest();
$eventTest->runTests();
