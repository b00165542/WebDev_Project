<?php
require_once '../Classes/dbConnection.php';

class Event
{
    private $eventID;
    private $eventName;
    private $eventLocation;
    private $eventDate;
    private $eventCapacity;
    private $eventPrice;

    public function __construct($eventName, $eventLocation, $eventDate, $eventPrice, $eventCapacity){
        $this->eventName = $eventName;
        $this->eventLocation = $eventLocation;
        $this->eventDate = $eventDate;
        $this->eventPrice = $eventPrice;
        $this->eventCapacity = $eventCapacity;
    }
    public function getEventID(){
        return $this->eventID;
    }
    public function setEventID($eventID){
        $this->eventID = $eventID;
        return $this;
    }
    public function getEventName(){
        return $this->eventName;
    }
    public function getEventLocation(){
        return $this->eventLocation;
    }
    public function getEventDate(){
        return $this->eventDate;
    }

    public function getEventPrice(){
        return $this->eventPrice;
    }
    

    public function getEventCapacity(){
        return $this->eventCapacity;
    }

    public function saveEvent(){
        $db = dbConnection::getConnection();

        if ($this->eventID) {
            $sql = "UPDATE events SET 
                    eventName = :eventName, 
                    eventLocation = :eventLocation, 
                    eventDate = :eventDate, 
                    eventPrice = :eventPrice, 
                    eventCapacity = :eventCapacity 
                    WHERE id = :eventID";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':eventID', $this->eventID);
            $stmt->bindParam(':eventName', $this->eventName);
            $stmt->bindParam(':eventLocation', $this->eventLocation);
            $stmt->bindParam(':eventDate', $this->eventDate);
            $stmt->bindParam(':eventPrice', $this->eventPrice);
            $stmt->bindParam(':eventCapacity', $this->eventCapacity);
        }
        else{
            $new_event = [
                'eventName' => $this->eventName,
                'eventLocation' => $this->eventLocation,
                'eventDate' => $this->eventDate,
                'eventPrice' => $this->eventPrice,
                'eventCapacity' => $this->eventCapacity
            ];
            $sql = sprintf(
                "INSERT INTO events (%s) VALUES (%s)",
                implode(", ", array_keys($new_event)),
                ":" . implode(", :", array_keys($new_event))
            );
            $stmt = $db->prepare($sql);
            foreach ($new_event as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
        }
        $stmt->execute();

        if (!$this->eventID) {
            $this->eventID = $db->lastInsertId();
        }
        return true;
    }

    public static function getAll(){
        $db = dbConnection::getConnection();
        $sql = "SELECT * FROM events ORDER BY eventDate DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $events = [];
        foreach ($rows as $row) {
            $e = new Event(
                $row['eventName'],
                $row['eventLocation'],
                $row['eventDate'],
                $row['eventPrice'],
                $row['eventCapacity']
            );
            $e->setEventID($row['id']);
            $events[] = $e;
        }
        return $events;
    }

    public static function findById($eventId){
        $db = dbConnection::getConnection();
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $e = new Event(
            $row['eventName'],
            $row['eventLocation'],
            $row['eventDate'],
            $row['eventPrice'],
            $row['eventCapacity']
        );
        $e->setEventID($row['id']);
        return $e;
    }

    public static function searchEvents($search, $location = '') {
        $connection = dbConnection::getConnection();
        $sql = "SELECT * FROM events WHERE 1";
        $params = array();
        if ($search !== '') {
            $sql .= " AND eventName LIKE :search";
            $params[':search'] = '%' . $search . '%';
        }
        if ($location !== '') {
            $sql .= " AND eventLocation = :location";
            $params[':location'] = $location;
        }
        $stmt = $connection->prepare($sql);
        if (isset($params[':search'])) {
            $stmt->bindValue(':search', $params[':search']);
        }
        if (isset($params[':location'])) {
            $stmt->bindValue(':location', $params[':location']);
        }
        $stmt->execute();
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new Event($row['eventName'], $row['eventLocation'], $row['eventDate'], $row['eventPrice'], $row['eventCapacity']);
            $event->setEventID($row['id']);
            $events[] = $event;
        }
        return $events;
    }

    //Capacity logic
    public function getRemainingCapacity(){

        if ($this->eventCapacity === null) {
            return null;
        }
        $db = dbConnection::getConnection();

        $sql = "SELECT SUM(quantity) as sold FROM orders WHERE eventID = :id AND (status IS NULL OR status != 'refunded')";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $this->eventID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $sold = (int)$row['sold'];

        $capacity = $this->eventCapacity - $sold;

        if ($capacity < 0) {
            return 0;
        }
        else {
            return $capacity;
        }
    }
}