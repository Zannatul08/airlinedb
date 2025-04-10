<?php
require_once 'FlightObserver.php'; // for the Observer interface

class Flight {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function notify($flightId, $status, $gateNumber, $reason) {
        foreach ($this->observers as $observer) {
            $observer->update($flightId, $status, $gateNumber, $reason);
        }
    }

    public function updateFlight($flightId, $status, $gateNumber, $reason) {
        // Here you can put your DB update logic, e.g. using PDO or mysqli
        // For now, just simulating with echo
        echo "Flight {$flightId} updated to status '{$status}', gate {$gateNumber}, reason: {$reason}";

        // Notify observers
        $this->notify($flightId, $status, $gateNumber, $reason);
    }
}
?>
