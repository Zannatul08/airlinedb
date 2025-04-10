<?php
require_once 'Observer.php';
require_once '../db_connection.php';

class FlightObserver implements Observer {
    private $userId;

    public function __construct($userId) {
        $this->userId = $userId;
    }

    public function update($flightId, $status, $gateNumber, $reason) {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("INSERT INTO flight_status (flight_id, status_update, gate_number, reason) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $flightId, $status, $gateNumber, $reason);
        $stmt->execute();
        $stmt->close();
    }
}
?>