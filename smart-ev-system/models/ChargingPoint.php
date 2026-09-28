<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class ChargingPoint {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $stationId, array $data) {
        $chargerId = $data['chargerId'] ?? ('CHG-' . uniqid());
        $cypher = "
            MATCH (s:ChargingStation {stationId: \$stationId})
            CREATE (c:ChargingPoint {
                chargerId: \$chargerId,
                connectorType: \$connectorType,
                chargingPower: toFloat(\$chargingPower),
                status: \$status,
                pricePerKwh: toFloat(\$pricePerKwh),
                chargingSpeed: toFloat(\$chargingSpeed)
            })
            CREATE (s)-[:HAS_CHARGER]->(c)
            RETURN c;
        ";
        $params = [
            'stationId'     => $stationId,
            'chargerId'     => $chargerId,
            'connectorType' => $data['connectorType'] ?? 'CCS2',
            'chargingPower' => floatval($data['chargingPower'] ?? 150),
            'status'        => strtoupper($data['status'] ?? 'AVAILABLE'),
            'pricePerKwh'   => floatval($data['pricePerKwh'] ?? 18.5),
            'chargingSpeed' => floatval($data['chargingSpeed'] ?? 150)
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getByStationId(string $stationId) {
        $cypher = "
            MATCH (s:ChargingStation {stationId: \$stationId})-[:HAS_CHARGER]->(c:ChargingPoint)
            RETURN c.chargerId AS chargerId, c.connectorType AS connectorType, c.chargingPower AS chargingPower,
                   c.status AS status, c.pricePerKwh AS pricePerKwh, c.chargingSpeed AS chargingSpeed;
        ";
        return $this->db->runQuery($cypher, ['stationId' => $stationId]);
    }
}
