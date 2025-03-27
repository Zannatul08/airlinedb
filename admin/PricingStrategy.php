<?php
interface PricingStrategy {
    public function calculatePrice(float $basePrice): float;
}