<?php
namespace Services;

class BatteryService {
    /**
     * Calculate remaining range in km based on capacity (kWh), SOC (%), and efficiency (kWh/km)
     */
    public function calculateRemainingRange(float $batteryCapacity, float $currentSoc, float $efficiency): float {
        if ($efficiency <= 0) $efficiency = 0.16;
        $currentKwh = ($batteryCapacity * ($currentSoc / 100.0));
        return round($currentKwh / $efficiency, 1);
    }

    /**
     * Calculate energy required in kWh for a given distance
     */
    public function calculateEnergyRequired(float $distanceKm, float $efficiency): float {
        if ($efficiency <= 0) $efficiency = 0.16;
        return round($distanceKm * $efficiency, 2);
    }

    /**
     * Determine if EV can reach destination without charging
     */
    public function canReachDestination(float $batteryCapacity, float $currentSoc, float $distanceKm, float $efficiency, float $minSafetyMarginPct = 15.0): bool {
        $remainingSoc = $this->calculateBatteryAfterTrip($batteryCapacity, $currentSoc, $distanceKm, $efficiency);
        return $remainingSoc >= $minSafetyMarginPct;
    }

    /**
     * Calculate battery SOC % after completing trip distance
     */
    public function calculateBatteryAfterTrip(float $batteryCapacity, float $currentSoc, float $distanceKm, float $efficiency): float {
        if ($batteryCapacity <= 0) return 0;
        $energyNeeded = $this->calculateEnergyRequired($distanceKm, $efficiency);
        $currentKwh = ($batteryCapacity * ($currentSoc / 100.0));
        $remainingKwh = max(0, $currentKwh - $energyNeeded);
        return round(($remainingKwh / $batteryCapacity) * 100.0, 1);
    }

    /**
     * Calculate battery safety margin percentage
     */
    public function calculateSafetyMargin(float $remainingSoc): float {
        return round(max(0, min(100, $remainingSoc)), 1);
    }

    /**
     * Calculate kWh needed to charge up to target percentage (default 80%)
     */
    public function calculateChargingRequired(float $batteryCapacity, float $currentSoc, float $targetSoc = 80.0): float {
        if ($currentSoc >= $targetSoc) return 0.0;
        $neededSoc = $targetSoc - $currentSoc;
        return round(($batteryCapacity * ($neededSoc / 100.0)), 2);
    }
}
