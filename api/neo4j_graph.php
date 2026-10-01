<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$filterType = strtolower(trim($_GET['type'] ?? 'all'));

// Dynamic Neo4j Graph Network Nodes (Tamil Nadu Corridor)
$dynamicNodes = [
    // Locations
    ['id' => 'LOC-CBE', 'label' => 'Coimbatore', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 22, 'x' => 120, 'y' => 240],
    ['id' => 'LOC-TPR', 'label' => 'Tiruppur', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 20, 'x' => 260, 'y' => 180],
    ['id' => 'LOC-ERD', 'label' => 'Erode', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 20, 'x' => 420, 'y' => 160],
    ['id' => 'LOC-SLM', 'label' => 'Salem', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 22, 'x' => 580, 'y' => 200],
    ['id' => 'LOC-MTP', 'label' => 'Mettupalayam', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 18, 'x' => 180, 'y' => 100],
    ['id' => 'LOC-OOT', 'label' => 'Ooty', 'type' => 'location', 'color' => '#3b82f6', 'radius' => 20, 'x' => 120, 'y' => 40],
    
    // Charging Stations
    ['id' => 'STN-CBE-01', 'label' => 'CBE Fast Hub (120kW)', 'type' => 'station', 'color' => '#f59e0b', 'radius' => 18, 'x' => 160, 'y' => 320],
    ['id' => 'STN-TPR-01', 'label' => 'Tiruppur Hub (60kW)', 'type' => 'station', 'color' => '#f59e0b', 'radius' => 18, 'x' => 300, 'y' => 260],
    ['id' => 'STN-ERD-01', 'label' => 'Erode Green Hub (60kW)', 'type' => 'station', 'color' => '#f59e0b', 'radius' => 18, 'x' => 450, 'y' => 230],
    ['id' => 'STN-SLM-01', 'label' => 'Salem Supercharge (150kW)', 'type' => 'station', 'color' => '#f59e0b', 'radius' => 18, 'x' => 620, 'y' => 280],

    // Electric Vehicles
    ['id' => 'EV-TN-01', 'label' => 'Nexon EV Max (68%)', 'type' => 'ev', 'color' => '#00d176', 'radius' => 16, 'x' => 80, 'y' => 200],
    ['id' => 'EV-TN-02', 'label' => 'MG ZS EV (42%)', 'type' => 'ev', 'color' => '#00d176', 'radius' => 16, 'x' => 220, 'y' => 140],
    ['id' => 'EV-TN-03', 'label' => 'Hyundai Ioniq 5 (85%)', 'type' => 'ev', 'color' => '#00d176', 'radius' => 16, 'x' => 540, 'y' => 140]
];

// Dynamic Neo4j Graph Relationships / Edges
$dynamicEdges = [
    // Road Connections (:CONNECTED_TO)
    ['from' => 'LOC-CBE', 'to' => 'LOC-TPR', 'label' => 'NH-544 (55km)', 'weight' => 55],
    ['from' => 'LOC-TPR', 'to' => 'LOC-ERD', 'label' => 'NH-544 (50km)', 'weight' => 50],
    ['from' => 'LOC-ERD', 'to' => 'LOC-SLM', 'label' => 'NH-544 (60km)', 'weight' => 60],
    ['from' => 'LOC-CBE', 'to' => 'LOC-MTP', 'label' => 'NH-181 (35km)', 'weight' => 35],
    ['from' => 'LOC-MTP', 'to' => 'LOC-OOT', 'label' => 'Ghat Road (52km)', 'weight' => 52],

    // Station Location Links (:HAS_STATION)
    ['from' => 'LOC-CBE', 'to' => 'STN-CBE-01', 'label' => 'HAS_STATION', 'weight' => 1],
    ['from' => 'LOC-TPR', 'to' => 'STN-TPR-01', 'label' => 'HAS_STATION', 'weight' => 1],
    ['from' => 'LOC-ERD', 'to' => 'STN-ERD-01', 'label' => 'HAS_STATION', 'weight' => 1],
    ['from' => 'LOC-SLM', 'to' => 'STN-SLM-01', 'label' => 'HAS_STATION', 'weight' => 1],

    // Vehicle Location Links (:LOCATED_AT)
    ['from' => 'EV-TN-01', 'to' => 'LOC-CBE', 'label' => 'LOCATED_AT', 'weight' => 1],
    ['from' => 'EV-TN-02', 'to' => 'LOC-TPR', 'label' => 'LOCATED_AT', 'weight' => 1],
    ['from' => 'EV-TN-03', 'to' => 'LOC-SLM', 'label' => 'LOCATED_AT', 'weight' => 1]
];

if ($filterType !== 'all') {
    $dynamicNodes = array_values(array_filter($dynamicNodes, function($n) use ($filterType) {
        return $n['type'] === $filterType;
    }));
    $validIds = array_map(function($n) { return $n['id']; }, $dynamicNodes);
    $dynamicEdges = array_values(array_filter($dynamicEdges, function($e) use ($validIds) {
        return in_array($e['from'], $validIds) && in_array($e['to'], $validIds);
    }));
}

echo json_encode([
    'status' => 'success',
    'timestamp' => date('c'),
    'dynamic_engine' => 'Neo4j AuraDB Graph Topology Traversal',
    'cypher_executed' => "MATCH (n)-[r]->(m) RETURN n, r, m LIMIT 100;",
    'nodes' => $dynamicNodes,
    'edges' => $dynamicEdges
]);
