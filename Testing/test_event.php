<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

class EventTest {
    public function runTests() {
        $this->displayEventInfo();
    }

    private function displayEventInfo() {
        $event = new Event('X', 'Y', 'Z', 1, 2);
        echo 'Event Name: ' . $event->getEventName() . '<br>';
        echo 'Event Location: ' . $event->getEventLocation() . '<br>';
        echo 'Event Date: ' . $event->getEventDate() . '<br>';
        echo 'Event Price: ' . $event->getEventPrice() . '<br>';
        echo 'Event Capacity: ' . $event->getEventCapacity() . '<br>';
    }
}

$eventTest = new EventTest();
$eventTest->runTests();
?>
