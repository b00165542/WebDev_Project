<?php

use Cassandra\Date;

class Event
{
 public int $EventID;
 public String $eventName;
 public String $eventType;
 public DateTime $startTime;
 public DateTime $endTime;
 public Date $eventDate;

 public int $eventPrice;
 public int $eventCapacity;
}