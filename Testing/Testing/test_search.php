<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

/**
 * Basic Unit Test for the Event search functionality
 * Tests searching for events by name and location
 */
class SearchTest {
    private $testResults = [];
    private $testEventId = null;
    private $uniqueSearchTerm = '';
    
    /**
     * Run all tests
     */
    public function runTests() {
        $this->setupTestEvent();
        $this->testSearchByName();
        $this->testSearchByLocation();
        $this->testSearchBoth();
        $this->displayResults();
    }
    
    /**
     * Create a test event with unique name for our search tests
     */
    private function setupTestEvent() {
        // Create a unique search term
        $this->uniqueSearchTerm = 'TestSearch' . time();
        
        // Create event with the unique term in the name
        $uniqueName = $this->uniqueSearchTerm . ' Concert';
        $location = 'Test Arena';
        $date = '2025-10-15';
        $price = 39.99;
        $capacity = 200;
        
        $event = new Event($uniqueName, $location, $date, $price, $capacity);
        
        if ($event->saveEvent()) {
            $this->testEventId = $event->getEventID();
            $this->addResult('Setup test event for search', true, 'Created event with name: ' . $uniqueName);
        } else {
            $this->addResult('Setup test event for search', false, 'Failed to create test event');
        }
    }
    
    /**
     * Test searching events by name
     */
    private function testSearchByName() {
        if (!$this->uniqueSearchTerm) {
            $this->addResult('Search by name', false, 'No unique search term available');
            return;
        }
        
        // Search for events with our unique term
        $results = Event::searchEvents($this->uniqueSearchTerm);
        
        // Should find at least one (our test event)
        $foundOurs = false;
        foreach ($results as $event) {
            if ($event->getEventID() == $this->testEventId) {
                $foundOurs = true;
                break;
            }
        }
        
        $this->addResult('Search by name', $foundOurs, 'Found ' . count($results) . ' results');
    }
    
    /**
     * Test searching events by location
     */
    private function testSearchByLocation() {
        // Search for events in 'Test Arena'
        $results = Event::searchEvents('', 'Test Arena');
        
        // Should find at least one (our test event)
        $foundOurs = false;
        foreach ($results as $event) {
            if ($event->getEventID() == $this->testEventId) {
                $foundOurs = true;
                break;
            }
        }
        
        $this->addResult('Search by location', $foundOurs, 'Found ' . count($results) . ' results');
    }
    
    /**
     * Test searching events by both name and location
     */
    private function testSearchBoth() {
        if (!$this->uniqueSearchTerm) {
            $this->addResult('Search by name and location', false, 'No unique search term available');
            return;
        }
        
        // Search for events with our unique term and location
        $results = Event::searchEvents($this->uniqueSearchTerm, 'Test Arena');
        
        // Should find at least one (our test event)
        $foundOurs = false;
        foreach ($results as $event) {
            if ($event->getEventID() == $this->testEventId) {
                $foundOurs = true;
                break;
            }
        }
        
        $this->addResult('Search by name and location', $foundOurs, 'Found ' . count($results) . ' results');
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
        echo "<h1>Event Search Unit Tests</h1>";
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
$searchTest = new SearchTest();
$searchTest->runTests();
?>
