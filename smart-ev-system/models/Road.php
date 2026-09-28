<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class Road {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function createConnection(string $fromLocName, string $toLocName, array $props) {
        $cypher = "
            MATCH (a:Location), (b:Location)
            WHERE toLower(a.name) = toLower(\$fromLoc) AND toLower(b.name) = toLower(\$toLoc)
            MERGE (a)-[r:CONNECTED_TO {
                roadId: \$roadId,
                name: \$name,
                distance: toFloat(\$distance),
                travelTime: toFloat(\$travelTime),
                trafficLevel: \$trafficLevel,
                status: \$status,
                energyCost: toFloat(\$energyCost)
            }]->(b)
            RETURN r;
        ";
        $params = [
            'fromLoc'      => $fromLocName,
            'toLoc'        => $toLocName,
            'roadId'       => $props['roadId'] ?? ('RD-' . uniqid()),
            'name'         => $props['name'] ?? ($fromLocName . ' to ' . $toLocName . ' Highway'),
            'distance'     => floatval($props['distance']),
            'travelTime'   => floatval($props['travelTime']),
            'trafficLevel' => $props['trafficLevel'] ?? 'LOW',
            'status'       => $props['status'] ?? 'OPEN',
            'energyCost'   => floatval($props['energyCost'] ?? ($props['distance'] * 0.16))
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getAllRoads() {
        $cypher = "
            MATCH (a:Location)-[r:CONNECTED_TO]->(b:Location)
            RETURN r.roadId AS roadId, r.name AS name, a.name AS startLocation, b.name AS endLocation,
                   r.distance AS distance, r.travelTime AS travelTime, r.trafficLevel AS trafficLevel,
                   r.status AS status, r.energyCost AS energyCost;
        ";
        return $this->db->runQuery($cypher);
    }
}
