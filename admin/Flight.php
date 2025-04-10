<?php
require_once 'Observer.php';

class Flight {
    private $observers = [];
    private $flightId;
    private $status;
    private $gateNumber;

    public function __construct($flightId, $status, $gateNumber) {
        $this->flightId = $flightId;
        $this->status = $status;
        $this->gateNumber = $gateNumber;
    }

    public function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notifyObservers($reason) {
        foreach ($this->observers as $observer) {
            $observer->update($this->flightId, $this->status, $this->gateNumber, $reason);
        }
    }

    public function setStatus($status, $reason = null) {
        $this->status = $status;
        $this->notifyObservers($reason);
    }

    public function setGateNumber($gateNumber, $reason = null) {
        $this->gateNumber = $gateNumber;
        $this->notifyObservers($reason);
    }

    public function getFlightId() {
        return $this->flightId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getGateNumber() {
        return $this->gateNumber;
    }
}
?>