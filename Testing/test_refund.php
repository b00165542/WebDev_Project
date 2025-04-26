<?php
require_once '../Classes/dbConnection.php';
require_once '../Classes/Refund.php';
require_once '../Classes/Order.php';
require_once '../Classes/Event.php';

class RefundTest {
    public function runTests() {
        $this->displayRefundInfo();
    }

    private function displayRefundInfo() {
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
        $order = Order::place(dbConnection::getConnection(), 1, $details, 1);
        $orderId = $order['id'] ?? null;
        echo 'Order Result:<br>';
        foreach ($order as $k => $v) {
            echo $k . ': ' . (is_array($v) ? json_encode($v) : $v) . '<br>';
        }
        if ($orderId) {
            $refund = new Refund();
            $result = $refund->processRefund(1, $orderId);
            echo 'Refund Result:<br>';
            foreach ($result as $k => $v) {
                echo $k . ': ' . (is_array($v) ? json_encode($v) : $v) . '<br>';
            }
        }
        $refund = new Refund();
        $refunds = $refund->getUserRefunds(1);
        echo 'User Refunds:<br>';
        echo json_encode($refunds);
    }
}

$refundTest = new RefundTest();
$refundTest->runTests();
?>
