<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

class SearchTest {
    public function runTests() {
        $this->displaySearchResults();
    }

    private function displaySearchResults() {
        // Search for test event by known values
        $byName = Event::searchEvents('X');
        echo 'Search by Name:<br>';
        foreach ($byName as $event) {
            echo 'Event: ' . $event->getEventName() . ', Location: ' . $event->getEventLocation() . ', Date: ' . $event->getEventDate() . '<br>';
        }
        $byLocation = Event::searchEvents('', 'Y');
        echo 'Search by Location:<br>';
        foreach ($byLocation as $event) {
            echo 'Event: ' . $event->getEventName() . ', Location: ' . $event->getEventLocation() . ', Date: ' . $event->getEventDate() . '<br>';
        }
    }
}

$searchTest = new SearchTest();
$searchTest->runTests();
?>
