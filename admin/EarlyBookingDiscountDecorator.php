<?php
class EarlyBookingDiscountDecorator extends DiscountDecorator {
    private $discountPercentage;
    private $flightId;

    public function __construct(TicketComponent $ticketComponent, $flightId) {
        parent::__construct($ticketComponent);
        $this->flightId = $flightId;
        $this->discountPercentage = $this->calculateDiscount();
    }

    private function calculateDiscount(): float {
        $conn = Database::getInstance()->getConnection();
        $stmt = $conn->prepare("SELECT departure_time FROM flight WHERE flight_id = ?");
        $stmt->bind_param("i", $this->flightId);
        $stmt->execute();
        $result = $stmt->get_result();
        $flight = $result->fetch_assoc();

        $departureDate = new DateTime($flight['departure_time']);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($departureDate);
        $daysUntilDeparture = $interval->days;

        return ($daysUntilDeparture > 30) ? 15.00 : 0.00; // 15% discount for early bookings
    }

    public function getPrice(): float {
        $originalPrice = $this->ticketComponent->getPrice();
        $discount = $originalPrice * ($this->discountPercentage / 100);
        return $originalPrice - $discount;
    }

    public function getDescription(): string {
        if ($this->discountPercentage > 0) {
            return $this->ticketComponent->getDescription() . " + Early Booking Discount (" . $this->discountPercentage . "%)";
        }
        return $this->ticketComponent->getDescription();
    }

    public function getDiscountPercentage(): float {
        return $this->discountPercentage;
    }
}