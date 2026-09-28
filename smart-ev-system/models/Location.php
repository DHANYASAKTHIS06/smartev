<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class Location {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(array $data) {
        $cypher = "
            CREATE (l:Location {
                locationId: \$locationId,
                name: \$name,
                latitude: toFloat(\$latitude),
                longitude: toFloat(\$longitude),
                address: \$address,
                city: \$city,
                type: \$type
            })
            RETURN l;
        ";
        $params = [
            'locationId' => $data['locationId'] ?? ('LOC-' . uniqid()),
            'name'       => $data['name'],
            'latitude'   => floatval($data['latitude'] ?? 11.0168),
            'longitude'  => floatval($data['longitude'] ?? 76.9558),
            'address'    => $data['address'] ?? '',
            'city'       => $data['city'] ?? 'Coimbatore',
            'type'       => $data['type'] ?? 'City'
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getAll() {
        $cypher = "MATCH (l:Location) RETURN l.locationId AS locationId, l.name AS name, l.latitude AS latitude, l.longitude AS longitude, l.address AS address, l.city AS city, l.type AS type ORDER BY l.name ASC;";
        return $this->db->runQuery($cypher);
    }

    public function findByName(string $name) {
        $cypher = "MATCH (l:Location) WHERE toLower(l.name) CONTAINS toLower(\$name) RETURN l.locationId AS locationId, l.name AS name, l.latitude AS latitude, l.longitude AS longitude, l.city AS city LIMIT 1;";
        $rows = $this->db->runQuery($cypher, ['name' => $name]);
        return $rows[0] ?? null;
    }
}
