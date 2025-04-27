<?php
include "../Layout/Header.php";
require_once '../Classes/dbConnection.php';
require_once '../Classes/Event.php';

$events = array();
$error_message = '';
$success_message = '';


$conn = dbConnection::getConnection();

if (isset($_GET['search'])){
    $search = $_GET['search'];
}
else {
    $search = '';
}
if (isset($_GET['location']) && $_GET['location'] !== 'all'){
    $location = $_GET['location'];
}
else{
    $location = '';
}
$events = Event::searchEvents($search, $location);
?>

<h1>Sports Events</h1>
<p>Discover and register for exciting sports events happening near you!</p>

<form method="get" action="/SET/public/product.php" class="search-form">
    <input type="text" name="search" placeholder="Search events..." value="<?php if (isset($_GET['search'])){ echo htmlspecialchars($_GET['search']); } ?>">
    <select name="location">
        <option value="all">All Locations</option>
        <?php
        $locations = array();
        foreach ($events as $event) {
            $loc = $event->getEventLocation();
            if (!in_array($loc, $locations)){
                $locations[] = $loc;
            }
        }
        foreach ($locations as $location) {
            echo '<option value="' . htmlspecialchars($location) . '"';
            if (isset($_GET['location']) && $_GET['location'] === $location){
                echo ' selected';
            }
            echo '>' . htmlspecialchars($location) . '</option>';
        }
        ?>
    </select>
    <button type="submit" class="btn">Search</button>
</form>

<?php if (empty($events)){ ?>
    <p>No events found.</p>
<?php } else{ ?>
    <div>
        <?php foreach ($events as $index => $event) { ?>
        <div>
            <h3><?php echo htmlspecialchars($event->getEventName()); ?></h3>
            <p>Location: <?php echo htmlspecialchars($event->getEventLocation()); ?></p>
            <p>Date: <?php echo htmlspecialchars(strval($event->getEventDate())); ?></p>
            <p>Price: $<?php echo htmlspecialchars(number_format($event->getEventPrice(), 2)); ?></p>
            <?php if (!empty($event->getEventCapacity()) && $event->getRemainingCapacity() !== null && $event->getRemainingCapacity() <= 0){ ?>
                <span class="sold-out-message">SOLD OUT</span>
            <?php } else{ ?>
                <a href="/SET/public/event.php?id=<?php echo $event->getEventId(); ?>" class="btn">View Details</a>
            <?php } ?>
            <?php if (!empty($event->getEventCapacity())){ ?>
                <?php $remaining = $event->getRemainingCapacity(); ?>
                <?php if ($remaining > 0){ ?>
                    <p>Capacity: <?php echo $remaining; ?>/<?php echo $event->getEventCapacity(); ?></p>
                <?php } ?>
            <?php } ?>
        </div>
        <?php if ($index < count($events) - 1){ echo '<hr>'; } ?>
        <?php } ?>
    </div>
<?php } ?>

<?php include "../Layout/Footer.php" ?>