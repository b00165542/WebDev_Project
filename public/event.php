<?php
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

$event_id = (int)$_GET['id'];

$event = Event::findById($event_id);
?>

<div class="event-details-page">
    <h1><?php echo htmlspecialchars((string)$event->getEventName()); ?></h1>
    <div class="event-details-container">
        <div class="event-image-wrapper">
            <img src="css/images/img.jpg" alt="Event Image" class="event-image">
        </div>
        <div class="event-info">
            <h2>Event Details</h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars((string)$event->getEventLocation()); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars((string)$event->getEventDate()); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($event->getEventPrice(), 2); ?></p>
            <?php if ($event->getEventCapacity()){
                $remaining = $event->getRemainingCapacity();
                if ($remaining > 0){
                    echo '<p><strong>Capacity:</strong> ' . $remaining . '/' . $event->getEventCapacity() . '</p>';
                } else{
                    echo '<p class="sold-out-message"><strong>Sold Out</strong></p>';
                }
            }
            ?>
        </div>
        <div class="event-actions">
            <?php if ($event->getRemainingCapacity() > 0){ ?>
                <a href="checkout.php?event=<?php echo $event->getEventID(); ?>" class="btn">Buy Tickets</a>
            <?php } ?>
            <a href="product.php" class="btn">To Events</a>
        </div>
    </div>
</div>

<?php include "../Layout/Footer.php"; ?>
