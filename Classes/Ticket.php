<?php

class Ticket extends Event
{
  public int $TicketID;
  public $UserID;
  public $EventName;
  public $EventDescription;
  public $EventStartTime;
  public $EventEndTime;
  public $EventPrice;


  function getTicketID() {
      return $this->TicketID;
  }

  function getUserID() {
      return $this->UserID;
  }

  function getEventID() {
      return $this->EventID;
  }
  function getEventName() {
      return $this->EventName;
  }
  function getEventDescription() {
      return $this->EventDescription;
  }
  function getEventStartTime() {
      return $this->EventStartTime;
  }
  function getEventEndTime() {
      return $this->EventEndTime;
  }
  function getEventPrice() {

      return $this->EventPrice;
  }
  function setTicketID($TicketID) {
      $this->TicketID = $TicketID;
  }
  function setUserID($UserID) {
      $this->UserID = $UserID;
  }
  function setEventID($EventID) {
      $this->EventID = $EventID;
  }
  function setEventName($EventName) {
      $this->EventName = $EventName;
  }
  function setEventDescription($EventDescription) {
      $this->EventDescription = $EventDescription;
  }
}
