<?php
// Order.php
require_once 'Event.php';
require_once 'Ticket.php';

class Order extends Event {
    public int $orderID;
    public DateTime $orderDate;
    public int $totalPrice;

    // Including Ticket functionality via composition
    public Ticket $ticket;

    public function __construct(
        int $orderID,
        DateTime $orderDate,
        int $totalPrice,
        Ticket $ticket,
        string $eventName
    ) {
        parent::__construct($eventName); // Initialize Event
        $this->orderID = $orderID;
        $this->orderDate = $orderDate;
        $this->totalPrice = $totalPrice;
        $this->ticket = $ticket;
    }

    public function displayOrder() {
        echo "Order ID: " . $this->orderID . "<br>";
        echo "Order Date: " . $this->orderDate->format('Y-m-d') . "<br>";
        echo "Total Price: " . $this->totalPrice . "<br>";
        echo "Event Name: " . $this->eventName . "<br>";
        echo "Ticket Type: " . $this->ticket->ticketType . "<br>";
    }
}
?>
