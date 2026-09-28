<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class DemandRecord {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $stationId, array $data) {
        $demandId = $data['demandId'] ?? ('DEM-' . uniqid());
        $cypher = "
            MATCH (st:ChargingStation {stationId: \$stationId})
            CREATE (d:DemandRecord {
                demandId: \$demandId,
                timestamp: \$timestamp,
                dayOfWeek: \$dayOfWeek,
                hour: toInteger(\$hour),
                chargingSessions: toInteger(\$chargingSessions),
                energyConsumed: toFloat(\$energyConsumed),
                demandLevel: \$demandLevel,
                waitingTime: toInteger(\$waitingTime)
            })
            CREATE (st)-[:HAS_DEMAND]->(d)
            RETURN d;
        ";
        $params = [
            'stationId'        => $stationId,
            'demandId'         => $demandId,
            'timestamp'        => $data['timestamp'] ?? date('Y-m-d H:i:s'),
            'dayOfWeek'        => $data['dayOfWeek'] ?? date('l'),
            'hour'             => intval($data['hour'] ?? date('H')),
            'chargingSessions' => intval($data['chargingSessions'] ?? 5),
            'energyConsumed'   => floatval($data['energyConsumed'] ?? 120.5),
            'demandLevel'      => strtoupper($data['demandLevel'] ?? 'MEDIUM'),
            'waitingTime'      => intval($data['waitingTime'] ?? 10)
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getByStationId(string $stationId) {
        $cypher = "
            MATCH (st:ChargingStation {stationId: \$stationId})-[:HAS_DEMAND]->(d:DemandRecord)
            RETURN d.demandId AS demandId, d.timestamp AS timestamp, d.dayOfWeek AS dayOfWeek,
                   d.hour AS hour, d.chargingSessions AS chargingSessions, d.energyConsumed AS energyConsumed,
                   d.demandLevel AS demandLevel, d.waitingTime AS waitingTime
            ORDER BY d.hour ASC;
        ";
        return $this->db->runQuery($cypher, ['stationId' => $stationId]);
    }
}
