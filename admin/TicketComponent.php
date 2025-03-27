<?php
interface TicketComponent {
    public function getPrice(): float;
    public function getDescription(): string; // To describe the applied discounts
}