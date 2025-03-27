<?php
class EconomyPricing implements PricingStrategy {
    public function calculatePrice(float $basePrice): float {
        return $basePrice * 1.0; // No additional multiplier for economy
    }
}