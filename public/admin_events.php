<?php
require_once '../Classes/session.php';
session::requireLogin();
require_once '../Classes/dbConnection.php';
require_once '../Classes/Admin.php';
require_once '../Classes/Event.php';

$isLoggedIn = true;
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
if (!$isAdmin) {
    header("Location: /SET/public/login.php");
    exit;
}
$error_message = '';
$success_message = '';
$event_to_edit = null;
$conn = dbConnection::getConnection();
$admin = new Admin($_SESSION['userID'], $_SESSION['name'], $_SESSION['userEmail']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['save_event'])) {
            $eventId = $_POST['event_id'];
            $eventName = $_POST['event_name'];
            $eventLocation = $_POST['event_location'];
            $eventPrice = $_POST['event_price'];
            $eventCapacity = $_POST['event_capacity'];
            $eventDate = $_POST['event_date'];
            if ($eventId) {
                if ($admin->updateEvent($eventId, $eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity, null, null)) {
                    $success_message = "Event updated successfully!";
                } else {
                    $error_message = "Error updating event.";
                }
            } else {
                $newEvent = $admin->createEvent($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity, null, null);
                if ($newEvent && $newEvent->getEventID()) {
                    $success_message = "Event created successfully!";
                } else {
                    $error_message = "Error creating event.";
                }
            }
        }
        if (isset($_POST['delete_event'])) {
            $eventId = $_POST['event_id'];
            if ($eventId && $admin->deleteEvent($eventId)) {
                $success_message = "Event deleted successfully!";
            } else {
                $error_message = "Error deleting event.";
            }
        }
        if (isset($_POST['edit_event'])) {
            $eventId = $_POST['event_id'];
            if ($eventId) {
                $event_to_edit = $admin->getEventById($eventId);
            }
        }
    } catch (Exception $e) {}
}
$events = Event::getAll();
$conn = null;
?>
<?php include "../Layout/Header.php"; ?>
<div class="container">
    <h1>Event Management</h1>
    <?php if (!empty($error_message)) { echo '<div class="notification error">' . $error_message . '</div>'; } ?>
    <?php if (!empty($success_message)) { echo '<div class="notification success">' . $success_message . '</div>'; } ?>
    <form method="POST" action="/SET/public/admin_events.php">
        <?php if ($event_to_edit) { echo '<input type="hidden" name="event_id" value="' . $event_to_edit->getEventID() . '">'; } ?>
        <label for="event_name">Event Name</label>
        <input type="text" id="event_name" name="event_name" value="<?php if ($event_to_edit) { echo $event_to_edit->getEventName(); } ?>" required>
        <label for="event_location">Location</label>
        <input type="text" id="event_location" name="event_location" value="<?php if ($event_to_edit) { echo $event_to_edit->getEventLocation(); } ?>" required>
        <label for="event_date">Date</label>
        <input type="date" id="event_date" name="event_date" value="<?php if ($event_to_edit) { echo htmlspecialchars($event_to_edit->getEventDate()); } ?>" required>
        <label for="event_price">Price</label>
        <input type="number" id="event_price" name="event_price" min="0" step="0.01" value="<?php if ($event_to_edit) { echo $event_to_edit->getEventPrice(); } ?>" required>
        <label for="event_capacity">Capacity</label>
        <input type="number" id="event_capacity" name="event_capacity" min="1" value="<?php if ($event_to_edit) { echo $event_to_edit->getEventCapacity(); } ?>" required>
        <button type="submit" name="save_event" class="btn"><?php if ($event_to_edit) { echo 'Update'; } else { echo 'Create'; } ?></button>
        <?php if ($event_to_edit) { echo '<a href="/SET/public/admin_events.php" class="btn">Cancel</a>'; } ?>
    </form>
    <h2>Event List</h2>
    <?php if (empty($events)) { echo '<div class="notification info">No events found.</div>'; } else { ?>
    <ul>
        <?php foreach ($events as $event) { ?>
            <li>
                <?php echo $event->getEventName() . ' (' . $event->getEventLocation() . ')'; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="event_id" value="<?php echo $event->getEventID(); ?>">
                    <button type="submit" name="edit_event" class="btn">Edit</button>
                    <button type="submit" name="delete_event" class="btn" onclick="return confirm('Delete this event?');">Delete</button>
                </form>
            </li>
        <?php } ?>
    </ul>
    <?php } ?>
</div>
<?php include "../Layout/Footer.php"; ?>
