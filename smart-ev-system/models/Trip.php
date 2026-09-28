<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class Trip {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $userId, array $data) {
        $tripId = $data['tripId'] ?? ('TRIP-' . uniqid());
        $cypher = "
            MATCH (u:User {userId: \$userId})
            CREATE (t:Trip {
                tripId: \$tripId,
                startLocation: \$startLocation,
                destination: \$destination,
                distance: toFloat(\$distance),
                travelTime: toFloat(\$travelTime),
                energyRequired: toFloat(\$energyRequired),
                chargingCost: toFloat(\$chargingCost),
                routeType: \$routeType,
                batterySafety: toFloat(\$batterySafety),
                status: \$status,
                createdAt: \$createdAt
            })
            CREATE (u)-[:PLANNED]->(t)
            RETURN t;
        ";
        $params = [
            'userId'         => $userId,
            'tripId'         => $tripId,
            'startLocation'  => $data['startLocation'],
            'destination'    => $data['destination'],
            'distance'       => floatval($data['distance']),
            'travelTime'     => floatval($data['travelTime']),
            'energyRequired' => floatval($data['energyRequired']),
            'chargingCost'   => floatval($data['chargingCost'] ?? 0),
            'routeType'      => $data['routeType'] ?? 'SMART_RECOMMENDED',
            'batterySafety'  => floatval($data['batterySafety'] ?? 92.0),
            'status'         => $data['status'] ?? 'COMPLETED',
            'createdAt'      => date('Y-m-d H:i:s')
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getByUserId(string $userId) {
        $cypher = "
            MATCH (u:User {userId: \$userId})-[:PLANNED]->(t:Trip)
            RETURN t.tripId AS tripId, t.startLocation AS startLocation, t.destination AS destination,
                   t.distance AS distance, t.travelTime AS travelTime, t.energyRequired AS energyRequired,
                   t.chargingCost AS chargingCost, t.routeType AS routeType, t.batterySafety AS batterySafety,
                   t.status AS status, t.createdAt AS createdAt
            ORDER BY t.createdAt DESC;
        ";
        return $this->db->runQuery($cypher, ['userId' => $userId]);
    }

    public function getAll() {
        $cypher = "
            MATCH (u:User)-[:PLANNED]->(t:Trip)
            RETURN t.tripId AS tripId, u.name AS userName, t.startLocation AS startLocation, t.destination AS destination,
                   t.distance AS distance, t.travelTime AS travelTime, t.energyRequired AS energyRequired,
                   t.chargingCost AS chargingCost, t.status AS status, t.createdAt AS createdAt
            ORDER BY t.createdAt DESC;
        ";
        return $this->db->runQuery($cypher);
    }
}
