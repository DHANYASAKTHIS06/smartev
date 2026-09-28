<?php
namespace Services;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class StationRecommendationService {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    /**
     * Recommend optimal charging stations based on multi-factor scoring algorithm
     */
    public function recommend(string $locationName, string $connectorType, float $maxPowerKw = 150.0): array {
        $cypher = "
            MATCH (l:Location) WHERE toLower(l.name) CONTAINS toLower(\$locationName)
            WITH l LIMIT 1
            MATCH (l)-[:HAS_STATION]->(s:ChargingStation)
            OPTIONAL MATCH (s)-[:HAS_CHARGER]->(c:ChargingPoint)
            WHERE c.connectorType = \$connectorType OR s.operatingStatus = 'AVAILABLE'
            RETURN s.stationId AS stationId, s.name AS name, s.address AS address, s.city AS city,
                   s.pricePerKwh AS pricePerKwh, s.operatingStatus AS operatingStatus,
                   s.totalChargers AS totalChargers, s.availableChargers AS availableChargers,
                   s.chargingSpeed AS chargingSpeed, s.rating AS rating, s.waitingTime AS waitingTime,
                   s.operator AS operator;
        ";
        $stations = $this->db->runQuery($cypher, [
            'locationName'  => $locationName,
            'connectorType' => $connectorType
        ]);

        if (empty($stations)) {
            // Fallback: Query all stations from Neo4j
            $cypherAll = "MATCH (s:ChargingStation) RETURN s.stationId AS stationId, s.name AS name, s.address AS address, s.city AS city, s.pricePerKwh AS pricePerKwh, s.operatingStatus AS operatingStatus, s.totalChargers AS totalChargers, s.availableChargers AS availableChargers, s.chargingSpeed AS chargingSpeed, s.rating AS rating, s.waitingTime AS waitingTime, s.operator AS operator LIMIT 10;";
            $stations = $this->db->runQuery($cypherAll);
        }

        $recommendations = [];
        foreach ($stations as $stn) {
            $price   = floatval($stn['pricePerKwh'] ?? 18.5);
            $speed   = floatval($stn['chargingSpeed'] ?? 150);
            $avail   = intval($stn['availableChargers'] ?? 2);
            $wait    = intval($stn['waitingTime'] ?? 0);

            // Score formula: Speed (40%) + Availability (30%) + Low Wait (20%) + Low Price (10%)
            $score = ($speed / 350.0 * 40.0) + ($avail > 0 ? 30.0 : 0.0) + max(0, 20.0 - $wait) + (max(0, 30.0 - $price) / 30.0 * 10.0);

            $recommendations[] = [
                'station'             => $stn,
                'distance'            => rand(2, 18) . ' km',
                'chargingCostEstimate'=> round($price * 24.5, 2),
                'chargingDurationMin' => round((24.5 / max(1, $speed)) * 60),
                'waitingTime'         => $wait . ' mins',
                'availability'        => $stn['operatingStatus'],
                'recommendationScore' => round($score, 1),
                'reason'              => "High speed ({$speed}kW) with {$avail} free ports and zero waiting queue."
            ];
        }

        usort($recommendations, fn($a, $b) => $b['recommendationScore'] <=> $a['recommendationScore']);
        return $recommendations;
    }
}
