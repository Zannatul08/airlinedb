<?php
class BusinessPricing implements PricingStrategy {
    public function calculatePrice(float $basePrice): float {
        return $basePrice * 1.5; // 50% more expensive than economy
    }
}