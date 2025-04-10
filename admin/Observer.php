<?php
interface Observer {
    public function update($flightId, $status, $gateNumber, $reason);
}
?>