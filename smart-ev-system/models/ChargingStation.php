<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class ChargingStation {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(array $data, string $locationName = 'Coimbatore') {
        $stationId = $data['stationId'] ?? ('STN-' . uniqid());
        $cypher = "
            MATCH (l:Location) WHERE toLower(l.name) CONTAINS toLower(\$locationName)
            WITH l LIMIT 1
            CREATE (s:ChargingStation {
                stationId: \$stationId,
                name: \$name,
                latitude: toFloat(\$latitude),
                longitude: toFloat(\$longitude),
                address: \$address,
                city: \$city,
                pricePerKwh: toFloat(\$pricePerKwh),
                operatingStatus: \$operatingStatus,
                totalChargers: toInteger(\$totalChargers),
                availableChargers: toInteger(\$availableChargers),
                chargingSpeed: toFloat(\$chargingSpeed),
                rating: toFloat(\$rating),
                waitingTime: toInteger(\$waitingTime),
                operator: \$operator
            })
            CREATE (l)-[:HAS_STATION]->(s)
            RETURN s;
        ";
        $params = [
            'locationName'      => $locationName,
            'stationId'          => $stationId,
            'name'               => $data['name'],
            'latitude'           => floatval($data['latitude'] ?? 11.0168),
            'longitude'          => floatval($data['longitude'] ?? 76.9558),
            'address'            => $data['address'] ?? '',
            'city'               => $data['city'] ?? 'Coimbatore',
            'pricePerKwh'        => floatval($data['pricePerKwh'] ?? 18.5),
            'operatingStatus'    => $data['operatingStatus'] ?? 'AVAILABLE',
            'totalChargers'      => intval($data['totalChargers'] ?? 8),
            'availableChargers'  => intval($data['availableChargers'] ?? 6),
            'chargingSpeed'      => floatval($data['chargingSpeed'] ?? 150),
            'rating'             => floatval($data['rating'] ?? 4.8),
            'waitingTime'        => intval($data['waitingTime'] ?? 0),
            'operator'           => $data['operator'] ?? 'SmartEV Network'
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getAll() {
        $cypher = "
            MATCH (s:ChargingStation)
            OPTIONAL MATCH (l:Location)-[:HAS_STATION]->(s)
            RETURN s.stationId AS stationId, s.name AS name, s.latitude AS latitude, s.longitude AS longitude,
                   s.address AS address, s.city AS city, s.pricePerKwh AS pricePerKwh, s.operatingStatus AS operatingStatus,
                   s.totalChargers AS totalChargers, s.availableChargers AS availableChargers,
                   s.chargingSpeed AS chargingSpeed, s.rating AS rating, s.waitingTime AS waitingTime,
                   s.operator AS operator, l.name AS locationName;
        ";
        return $this->db->runQuery($cypher);
    }

    public function findById(string $stationId) {
        $cypher = "
            MATCH (s:ChargingStation {stationId: \$stationId})
            OPTIONAL MATCH (l:Location)-[:HAS_STATION]->(s)
            OPTIONAL MATCH (s)-[:HAS_CHARGER]->(c:ChargingPoint)
            RETURN s.stationId AS stationId, s.name AS name, s.address AS address, s.city AS city,
                   s.pricePerKwh AS pricePerKwh, s.operatingStatus AS operatingStatus,
                   s.totalChargers AS totalChargers, s.availableChargers AS availableChargers,
                   s.chargingSpeed AS chargingSpeed, s.rating AS rating, s.waitingTime AS waitingTime,
                   s.operator AS operator, l.name AS locationName,
                   collect({chargerId: c.chargerId, connectorType: c.connectorType, status: c.status, power: c.chargingPower}) AS chargers
            LIMIT 1;
        ";
        $rows = $this->db->runQuery($cypher, ['stationId' => $stationId]);
        return $rows[0] ?? null;
    }

    public function updateStatus(string $stationId, string $status, int $availableChargers) {
        $cypher = "
            MATCH (s:ChargingStation {stationId: \$stationId})
            SET s.operatingStatus = \$status, s.availableChargers = toInteger(\$availableChargers)
            RETURN s;
        ";
        return $this->db->runQuery($cypher, [
            'stationId'         => $stationId,
            'status'            => strtoupper($status),
            'availableChargers' => $availableChargers
        ]);
    }
}
