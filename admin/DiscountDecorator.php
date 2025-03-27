<?php
abstract class DiscountDecorator implements TicketComponent {
    protected $ticketComponent;

    public function __construct(TicketComponent $ticketComponent) {
        $this->ticketComponent = $ticketComponent;
    }

    public function getPrice(): float {
        return $this->ticketComponent->getPrice();
    }

    public function getDescription(): string {
        return $this->ticketComponent->getDescription();
    }

    abstract public function getDiscountPercentage(): float;
}