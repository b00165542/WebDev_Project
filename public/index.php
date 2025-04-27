<?php 
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

$featured_event = Event::findById(1);
$upcoming_events = array_slice(Event::getAll(), 0, 3);
?>

<?php if ($featured_event){ ?>
    <h2>Featured Event</h2>
    <div class="featured-event">
        <h3><?php echo htmlspecialchars((string)$featured_event->getEventName()); ?></h3>
        <p>Location: <?php echo htmlspecialchars((string)$featured_event->getEventLocation()); ?></p>
        <p>Date: <?php echo htmlspecialchars((string)$featured_event->getEventDate()); ?></p>
        <p>Price: $<?php echo number_format($featured_event->getEventPrice(), 2); ?></p>
        <div class="event-actions">
            <a href="event.php?id=<?php echo $featured_event->getEventId(); ?>" class="btn">View Details</a>
        </div>
    </div>
<?php } ?>

<h2>Upcoming Events</h2>
<?php if (!empty($upcoming_events)){ ?>
    <div class="event-grid">
    <?php foreach ($upcoming_events as $event){ ?>
        <div class="event-card">
            <h3><?php echo htmlspecialchars((string)$event->getEventName()); ?></h3>
            <p>Location: <?php echo htmlspecialchars((string)$event->getEventLocation()); ?></p>
            <p>Date: <?php echo htmlspecialchars((string)$event->getEventDate()); ?></p>
            <p>Price: $<?php echo number_format($event->getEventPrice(), 2); ?></p>
            <div class="event-actions">
                <a href="event.php?id=<?php echo $event->getEventId(); ?>" class="btn">View Details</a>
            </div>
        </div>
    <?php } ?>
    </div>
<?php } else{ ?>
    <p>No upcoming events at this time. Check back soon!</p>
<?php } ?>

<p><a href="product.php" class="btn">View All Events</a></p>

<?php include "../Layout/Footer.php"; ?>
