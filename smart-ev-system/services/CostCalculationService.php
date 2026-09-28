<?php
namespace Services;

class CostCalculationService {
    /**
     * Compute comprehensive EV energy and charging cost metrics
     */
    public function calculate(float $distanceKm, float $efficiencyKwhKm, float $pricePerKwh, float $chargingPowerKw): array {
        if ($efficiencyKwhKm <= 0) $efficiencyKwhKm = 0.16;
        if ($chargingPowerKw <= 0) $chargingPowerKw = 150.0;

        $energyRequiredKwh = round($distanceKm * $efficiencyKwhKm, 2);
        $chargingCost      = round($energyRequiredKwh * $pricePerKwh, 2);
        $costPerKm         = $distanceKm > 0 ? round($chargingCost / $distanceKm, 2) : 0.0;
        $chargingTimeMins  = round(($energyRequiredKwh / $chargingPowerKw) * 60);

        return [
            'distanceKm'        => $distanceKm,
            'efficiencyKwhKm'   => $efficiencyKwhKm,
            'energyRequiredKwh' => $energyRequiredKwh,
            'chargingUnits'     => $energyRequiredKwh,
            'pricePerKwh'       => $pricePerKwh,
            'chargingCost'      => $chargingCost,
            'costPerKm'         => $costPerKm,
            'chargingTimeMins'  => $chargingTimeMins
        ];
    }
}
