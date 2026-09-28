<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class ChargingSession {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $evId, string $stationId, array $data) {
        $sessionId = $data['sessionId'] ?? ('SESS-' . uniqid());
        $cypher = "
            MATCH (ev:EV {evId: \$evId}), (st:ChargingStation {stationId: \$stationId})
            CREATE (cs:ChargingSession {
                sessionId: \$sessionId,
                startTime: \$startTime,
                endTime: \$endTime,
                energyConsumed: toFloat(\$energyConsumed),
                chargingCost: toFloat(\$chargingCost),
                duration: toInteger(\$duration),
                status: \$status
            })
            CREATE (ev)-[:HAS_SESSION]->(cs)
            CREATE (cs)-[:AT_STATION]->(st)
            RETURN cs;
        ";
        $params = [
            'evId'           => $evId,
            'stationId'      => $stationId,
            'sessionId'      => $sessionId,
            'startTime'      => $data['startTime'] ?? date('Y-m-d H:i:s'),
            'endTime'        => $data['endTime'] ?? date('Y-m-d H:i:s', strtotime('+30 mins')),
            'energyConsumed' => floatval($data['energyConsumed'] ?? 24.5),
            'chargingCost'   => floatval($data['chargingCost'] ?? 180),
            'duration'       => intval($data['duration'] ?? 30),
            'status'         => $data['status'] ?? 'COMPLETED'
        ];
        return $this->db->runQuery($cypher, $params);
    }
}
