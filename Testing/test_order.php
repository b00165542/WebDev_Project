<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';

class OrderTest {
    public function runTests() {
        $this->displayOrderInfo();
    }

    private function displayOrderInfo() {
        // Find the test event by known test values
        $events = Event::searchEvents('X', 'Y');
        $event = count($events) ? $events[0] : null;
        if (!$event) {
            echo "Test Event not found. Please run test_event.php first.";
            return;
        }
        $details = [
            'id' => $event->getEventID(),
            'eventName' => $event->getEventName(),
            'eventDate' => $event->getEventDate(),
            'eventLocation' => $event->getEventLocation(),
            'eventPrice' => $event->getEventPrice()
        ];
        $result = Order::place(dbConnection::getConnection(), 1, $details, 1);
        echo 'Order Result:<br>';
        foreach ($result as $k => $v) {
            echo $k . ': ' . (is_array($v) ? json_encode($v) : $v) . '<br>';
        }
    }
}

$orderTest = new OrderTest();
$orderTest->runTests();
?>
