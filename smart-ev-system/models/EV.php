<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class EV {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $userId, array $data) {
        $evId = $data['evId'] ?? ('EV-' . uniqid());
        $cypher = "
            MATCH (u:User {userId: \$userId})
            CREATE (ev:EV {
                evId: \$evId,
                model: \$model,
                batteryCapacity: toFloat(\$batteryCapacity),
                currentBattery: toFloat(\$currentBattery),
                connectorType: \$connectorType,
                maxChargingPower: toFloat(\$maxChargingPower),
                efficiency: toFloat(\$efficiency),
                registrationNumber: \$registrationNumber,
                createdAt: \$createdAt
            })
            CREATE (u)-[:OWNS]->(ev)
            RETURN ev;
        ";
        $params = [
            'userId'             => $userId,
            'evId'               => $evId,
            'model'              => $data['model'],
            'batteryCapacity'    => floatval($data['batteryCapacity']),
            'currentBattery'     => floatval($data['currentBattery'] ?? 100),
            'connectorType'      => $data['connectorType'],
            'maxChargingPower'   => floatval($data['maxChargingPower']),
            'efficiency'         => floatval($data['efficiency'] ?? 0.16),
            'registrationNumber' => $data['registrationNumber'] ?? '',
            'createdAt'          => date('Y-m-d H:i:s')
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getByUserId(string $userId) {
        $cypher = "
            MATCH (u:User {userId: \$userId})-[:OWNS]->(ev:EV)
            RETURN ev.evId AS evId, ev.model AS model, ev.batteryCapacity AS batteryCapacity,
                   ev.currentBattery AS currentBattery, ev.connectorType AS connectorType,
                   ev.maxChargingPower AS maxChargingPower, ev.efficiency AS efficiency,
                   ev.registrationNumber AS registrationNumber;
        ";
        return $this->db->runQuery($cypher, ['userId' => $userId]);
    }

    public function findById(string $evId) {
        $cypher = "MATCH (ev:EV {evId: \$evId}) RETURN ev.evId AS evId, ev.model AS model, ev.batteryCapacity AS batteryCapacity, ev.currentBattery AS currentBattery, ev.connectorType AS connectorType, ev.maxChargingPower AS maxChargingPower, ev.efficiency AS efficiency, ev.registrationNumber AS registrationNumber LIMIT 1;";
        $rows = $this->db->runQuery($cypher, ['evId' => $evId]);
        return $rows[0] ?? null;
    }

    public function updateBattery(string $evId, float $newSoc) {
        $cypher = "
            MATCH (ev:EV {evId: \$evId})
            SET ev.currentBattery = toFloat(\$newSoc)
            RETURN ev;
        ";
        return $this->db->runQuery($cypher, ['evId' => $evId, 'newSoc' => $newSoc]);
    }

    public function delete(string $evId) {
        $cypher = "MATCH (ev:EV {evId: \$evId}) DETACH DELETE ev;";
        return $this->db->runQuery($cypher, ['evId' => $evId]);
    }

    public function getAll() {
        $cypher = "MATCH (ev:EV) RETURN ev.evId AS evId, ev.model AS model, ev.batteryCapacity AS batteryCapacity, ev.currentBattery AS currentBattery, ev.connectorType AS connectorType, ev.maxChargingPower AS maxChargingPower, ev.efficiency AS efficiency;";
        return $this->db->runQuery($cypher);
    }
}
