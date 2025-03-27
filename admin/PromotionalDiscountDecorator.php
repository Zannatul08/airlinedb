<?php
class PromotionalDiscountDecorator extends DiscountDecorator {
    private $discountPercentage;

    public function __construct(TicketComponent $ticketComponent) {
        parent::__construct($ticketComponent);
        $this->discountPercentage = 10.00; // Fixed 10% promotional discount
    }

    public function getPrice(): float {
        $originalPrice = $this->ticketComponent->getPrice();
        $discount = $originalPrice * ($this->discountPercentage / 100);
        return $originalPrice - $discount;
    }

    public function getDescription(): string {
        return $this->ticketComponent->getDescription() . " + Promotional Discount (" . $this->discountPercentage . "%)";
    }

    public function getDiscountPercentage(): float {
        return $this->discountPercentage;
    }
}