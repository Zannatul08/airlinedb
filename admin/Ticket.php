<?php
class Ticket implements TicketComponent {
    private $basePrice;
    private $pricingStrategy;

    public function __construct(float $basePrice, PricingStrategy $pricingStrategy) {
        $this->basePrice = $basePrice;
        $this->pricingStrategy = $pricingStrategy;
    }

    public function getPrice(): float {
        return $this->pricingStrategy->calculatePrice($this->basePrice);
    }

    public function getDescription(): string {
        return "Base Price: $" . number_format($this->basePrice, 2);
    }
}